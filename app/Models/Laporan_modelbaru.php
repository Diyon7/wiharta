<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;
use DateTime;

class Laporan_model extends Model
{
    protected $DBGroup = 'default';

    protected $table      = 'pegawai';
    protected $primaryKey = 'pegawai_id';

    protected $allowedFields = ['pegawai_pin', 'pegawai_nip', 'pegawai_id', 'pegawai_nama', 'tgl_lahir', 'tgl_mulai_kerja', 'tgl_masuk_pertama', 'golongan', 'grup', 'grup_t', 'grup_jam_kerja', 'resign'];

    protected $request;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('default');
        $this->request = $request;
    }

    public function Alllaporan($data)
    {
        $k = $data['tgl'];
        return $this->db->query("SELECT pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_pin` AS idkar, pegawai.`golongan` AS golongan, pembagian2.`pembagian2_nama` AS divisi, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit, pegawai.`grup_jam_kerja` AS grupt, pembagian3.`pembagian3_nama` AS asal, pegawai.`golongan` AS golongan, pegawai.`tgl_mulai_kerja` AS tmt, pegawai.`grup` AS grup FROM pegawai
        left JOIN pembagian2 ON pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`
        left JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        left JOIN pembagian5 ON pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`
        left JOIN pembagian3 ON pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`
        WHERE pembagian3.`pembagian3_nama` LIKE '" . $data['vendor'] . "' AND (tgl_resign >= '" . $data['tgl'] . "' OR tgl_resign IS NULL)")
            ->getResultArray();
        // return $this->select('pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_pin` AS idkar, pegawai.`golongan` AS golongan, pembagian2.`pembagian2_nama` AS divisi, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit, pegawai.`grup_jam_kerja` AS grupt, pembagian3.`pembagian3_nama` AS asal, pegawai.`golongan` AS golongan, pegawai.`tgl_mulai_kerja` AS tmt, pegawai.`grup` AS grup')
        //     ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
        //     ->join('pembagian4', 'pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`')
        //     ->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`')
        //     ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
        //     ->like('pembagian3.`pembagian3_nama`', $data['vendor'])
        //     ->where('pegawai.`golongan`!=', '1')
        //     ->where("(tgl_resign >= '" . $data['tgl'] . "' OR tgl_resign IS NULL)")
        //     ->get()->getResultArray();
    }

    public function Dataabsen($form)
    {
        // foreach ($form['tblslaporan'] as $tbls) {
        $terlambat = 0;
        $kelebihanjam = 0;
        $finger = '';

        $mjkn2 = $this->db->query("SELECT jdw_kerja_d.`jdw_kerja_d_idx` AS idx FROM jdw_kerja_m
                        JOIN jdw_kerja_d ON jdw_kerja_m.`jdw_kerja_m_id`=jdw_kerja_d.`jdw_kerja_m_id`
                        LEFT JOIN jam_kerja ON jam_kerja.`jk_id` = jdw_kerja_d.`jk_id`
                        WHERE jdw_kerja_m.`jdw_kerja_m_kode`='" . $form['grupt'] . "'")->getResultArray();

        $timeakhir = $form['timeakhir'];
        $now = new DateTime();
        $datenow = $now->format('Y-m-d');
        $timeawal = $form['timeawal'];
        $tglt = $form['tglt'];
        $msk = [];
        $tm = [];


        for ($a = $form['tagihanawal']; $a <= $form['tagihanakhir']; $a->modify('+ 1 day')) {
            $tgllaporan[] = $tglt;
            $tglt = date('m/d', strtotime(' +1 days', strtotime($tglt)));

            $grup = $form['grupt'];

            $izincekinmin = $this->select("DATE_FORMAT(tbl_izin.`in`, '%y-%m-%d %H:%i:%s') AS cekin, '1' AS inoutm")
                ->join("tbl_izin", "pegawai.`pegawai_nip`=tbl_izin.`pegawai_nip`")
                ->where("tbl_izin.`pegawai_nip`", $form['idkar'])
                ->where("tbl_izin.`in` LIKE '$timeawal %'")
                ->get()->getResultArray();

            $izincekoutmax = $this->select("DATE_FORMAT(tbl_izin.`out`, '%y-%m-%d %H:%i:%s') AS cout, '2' AS inoutm")
                ->join("tbl_izin", "pegawai.`pegawai_nip`=tbl_izin.`pegawai_nip`")
                ->where("tbl_izin.`pegawai_nip`", $form['idkar'])
                ->where("tbl_izin.`in` LIKE '$timeawal %'")
                ->get()->getResultArray();

            $clor = "white";

            $day[] = date('D', strtotime($timeawal));
            $dayi = date('D', strtotime($timeawal));

            $masuk = 0;
            $tidakmasuk = 0;
            $izin = 0;
            // $dftizin = $this->db->query("SELECT pegawai_nip FROM tbl_izin
            //                             WHERE tanggal='$timeawal' AND verified='a' AND pegawai_nip='" . $form['idkar'] . "'")->getRowArray();


            foreach ($form['jkm'] as $jkmk) {
                $n = 0;

                if ($grup == $jkmk['kodejk']) {

                    $mjkn = $this->db->query("SELECT MAX(jdw_kerja_d.`jdw_kerja_d_idx`) AS idx FROM jdw_kerja_m
                        JOIN jdw_kerja_d ON jdw_kerja_m.`jdw_kerja_m_id`=jdw_kerja_d.`jdw_kerja_m_id`
                        LEFT JOIN jam_kerja ON jam_kerja.`jk_id` = jdw_kerja_d.`jk_id`
                        WHERE jdw_kerja_m.`jdw_kerja_m_kode`='" . $jkmk['kodejk'] . "'")->getRowArray();

                    $dtglta = new DateTime($jkmk['tglta']);
                    $dtimeawa = new DateTime($timeawal);
                    for ($i = $dtglta; $i <= $form['tagihanakhir']; $i->modify('+ 1 day')) {
                        $n++;
                        if ($n >  $mjkn['idx']) {
                            $n = 1;
                        }
                        if (date('Y-m-d', strtotime($timeawal)) === date_format($i, 'Y-m-d')) {
                            $tjk = $this->db->query("SELECT jdw_kerja_m.`jdw_kerja_m_kode` AS kodejk, jdw_kerja_d.`jdw_kerja_d_idx` AS idx, jdw_kerja_m.`jdw_kerja_m_periode` AS p, jdw_kerja_m.`jdw_kerja_m_mulai` AS tglta, jdw_kerja_d.`jdw_kerja_d_libur` AS libur, jam_kerja.`jk_bcin` AS smasuk, jam_kerja.`jk_durtime` AS durasi, jam_kerja.`jk_ecout` AS skeluar FROM jdw_kerja_m
                                    JOIN jdw_kerja_d ON jdw_kerja_m.`jdw_kerja_m_id`=jdw_kerja_d.`jdw_kerja_m_id`
                                    LEFT JOIN jam_kerja ON jam_kerja.`jk_id` = jdw_kerja_d.`jk_id`
                                    WHERE jdw_kerja_m.`jdw_kerja_m_kode`='" . $jkmk['kodejk'] . "' AND jdw_kerja_d.`jdw_kerja_d_idx`='" . $n . "'")->getRowArray();
                            if ($tjk['libur'] === '0') {
                                // if ($dftizin['pegawai_nip'] != null) {
                                //     $clor = "green";
                                //     $izin++;
                                //     $izinf[] = $izin;
                                // } else {
                                if ($timeawal <= $datenow) {

                                    // $duraw = $tjk['durasi'];
                                    // $durak = $tjk['durasi'];

                                    $inmin  = date('Y-m-d H:i:s', strtotime('-3 hours', strtotime($timeawal . ' ' . $tjk['smasuk'])));
                                    $inmax = date('Y-m-d H:i:s', strtotime('+4 hours', strtotime($timeawal . ' ' . $tjk['smasuk'])));

                                    $outmin = date('Y-m-d H:i:s', strtotime('+6 hours', strtotime($timeawal . ' ' . $tjk['smasuk'])));
                                    $outmax = date('Y-m-d H:i:s', strtotime('+17 hours', strtotime($timeawal . ' ' . $tjk['smasuk'])));

                                    $cekinmin = $this->select("pegawai.`pegawai_nip` AS idkar, pegawai.`pegawai_nama` AS nama, att_log.`inoutmode` AS inoutm, MIN(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cekin")
                                        ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                                        ->where('pegawai.`pegawai_pin`', $form['idkar'])
                                        ->where('pegawai.`resign`', '0')
                                        ->where("scan_date BETWEEN '$inmin' AND '$inmax'")
                                        ->get()->getResultArray();

                                    $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                                        ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                                        ->where('pegawai.`pegawai_pin`', $form['idkar'])
                                        ->where('pegawai.`resign`', '0')
                                        ->where("scan_date BETWEEN '$outmin' AND '$outmax'")
                                        ->get()->getResultArray();

                                    if ($izincekinmin != null) {
                                        $cekinmin = $izincekinmin;
                                        $cekoutmax = $izincekoutmax;
                                    }

                                    $jamkerja = strtotime($cekoutmax[0]['cout']) - strtotime($cekinmin[0]['cekin']);
                                    $jam = floor($jamkerja / (60 * 60));
                                    $menit = $jamkerja - $jam * (60 * 60);

                                    if ($cekinmin[0]['cekin'] == NULL) {
                                        $finger = ' I : ';
                                    } else {
                                        $finger = ' I : ' . date('H:i', strtotime($cekinmin[0]['cekin']));
                                    }

                                    if ($cekoutmax[0]['cout'] == NULL) {
                                        $finger .= ' O : ';
                                    } else {
                                        $finger .= ' O : ' . date('H:i', strtotime($cekoutmax[0]['cout']));
                                    }

                                    if ($cekinmin[0]['cekin'] == NULL) {
                                        $finger .= ' JK : ';
                                    } elseif ($cekoutmax[0]['cout'] == NULL) {
                                        $finger .= ' JK : ';
                                    } else {
                                        $finger .= ' JK : ' . $jam . ':' . floor($menit / 60);
                                    }

                                    if ($cekinmin[0]['cekin'] == NULL || $cekoutmax[0]['cout'] == NULL) {
                                        $clor = "red";
                                        $tidakmasuk++;
                                        $tm[] = $tidakmasuk;
                                    } else {
                                        $clor = "white";
                                        $wk = strtotime(date('H:i', strtotime($cekinmin[0]['cekin'])))  - strtotime(date('H:i', strtotime($tjk['smasuk'])));
                                        $toterlambat = floor($wk  / 60);
                                        if ($toterlambat <= 0) {
                                            $terlambat = $terlambat + 0;
                                        } elseif ($toterlambat <= 60) {
                                            $clor = "orange";
                                            $terlambat = $terlambat + 1;
                                        } elseif ($toterlambat <= 120) {
                                            $clor = "orange";
                                            $terlambat = $terlambat + 2;
                                        } elseif ($toterlambat <= 180) {
                                            $clor = "orange";
                                            $terlambat = $terlambat + 3;
                                        } elseif ($toterlambat <= 240) {
                                            $clor = "orange";
                                            $terlambat = $terlambat + 4;
                                        } elseif ($toterlambat <= 300) {
                                            $clor = "orange";
                                            $terlambat = $terlambat + 5;
                                        } elseif ($toterlambat <= 360) {
                                            $clor = "orange";
                                            $terlambat = $terlambat + 6;
                                        }

                                        $kj = (strtotime(date('H:i', strtotime($cekoutmax[0]['cout']))))  - (strtotime(date('H:i', strtotime($tjk['skeluar']))));
                                        $tokelebih = floor($kj  / 60);
                                        if ($tokelebih >= 480) {
                                            $clor = "grey";
                                            $kelebihanjam = $kelebihanjam + 8;
                                        } elseif ($tokelebih >= 420) {
                                            $clor = "grey";
                                            $kelebihanjam = $kelebihanjam + 7;
                                        } elseif ($tokelebih >= 360) {
                                            $clor = "grey";
                                            $kelebihanjam = $kelebihanjam + 6;
                                        } elseif ($tokelebih >= 300) {
                                            $clor = "grey";
                                            $kelebihanjam = $kelebihanjam + 5;
                                        } elseif ($tokelebih >= 240) {
                                            $clor = "grey";
                                            $kelebihanjam = $kelebihanjam + 4;
                                        } elseif ($tokelebih >= 180) {
                                            $clor = "grey";
                                            $kelebihanjam = $kelebihanjam + 3;
                                        } elseif ($tokelebih >= 120) {
                                            $clor = "grey";
                                            $kelebihanjam = $kelebihanjam + 2;
                                        } elseif ($tokelebih >= 60) {
                                            $clor = "grey";
                                            $kelebihanjam = $kelebihanjam + 1;
                                        } elseif ($tokelebih >= 0) {
                                            $kelebihanjam = $kelebihanjam + 0;
                                        }

                                        $masuk++;
                                        $msk[] = $masuk;
                                    }
                                } else {
                                    $finger = ' ';
                                    $clor = "white";
                                }
                                // }
                            } else {
                                $finger = ' ';
                                $clor = "yellow";
                            }
                        } else {
                            $none = [];
                        }
                        $tanggal[] = $n;
                    }
                }
            }

            $color[] = $clor;

            $trt = $terlambat;

            $kbhnj = $kelebihanjam;
            $finger2[] = $finger;

            $timeawal3[] = $timeawal;
            $timeawal = date('Y-m-d', strtotime('+1 days', strtotime($timeawal)));
        }
        // }
        $alldata[] = [
            'idkar' => $form['idkar'],
            'timeawal3' => $timeawal3,
            'terlambat' => $trt,
            'kelebihanjam' => $kbhnj,
            'm' => $mjkn2,
            'nama' => $form['nama'],
            'divisi' => $form['divisi'],
            'unit' => $form['unit'],
            'subunit' => $form['subunit'],
            // 'tanggal' => $dtimeawaght,
            'asal' => $form['asal'],
            'tm' => $tm,
            'msk' => $msk,
            // 'izinf' => $izinf,
            'golongan' => $form['golongan'],
            'tmt' => $form['tmt'],
            'grup' => $form['grup'],
            'finger' => $finger2,
            'color' => $color,
            'tgllaporan' => $tgllaporan,
            'day' => $day
        ];
        return $alldata;
    }

    public function Rekapabsen()
    {
    }
}