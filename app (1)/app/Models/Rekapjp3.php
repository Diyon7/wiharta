<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;
use DateTime;

class Rekapjp3 extends Model
{
    protected $DBGroup = 'seconddb';

    protected $table      = 'pegawai';
    protected $primaryKey = 'pegawai_id';

    protected $allowedFields = ['pegawai_pin', 'pegawai_nip', 'pegawai_id', 'pegawai_nama', 'tgl_lahir', 'tgl_mulai_kerja', 'tgl_masuk_pertama', 'golongan', 'grup', 'grup_t', 'resign'];

    protected $request;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->request = $request;
    }

    public function Alllaporan($vendor)
    {
        return $this->select('pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_nip` AS idkar, pegawai.`golongan` AS golongan, pembagian2.`pembagian2_nama` AS divisi, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit, pegawai.`grup_t` AS grupt, pembagian3.`pembagian3_nama` AS asal, pegawai.`golongan` AS golongan, pegawai.`tgl_mulai_kerja` AS tmt, pegawai.`grup` AS grup')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
            ->join('pembagian4', 'pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`')
            ->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
            ->where('pegawai.`resign`', '0')
            ->like('pembagian3.`pembagian3_nama`', $vendor)
            ->get()->getResultArray();
    }

    public function Dataabsen($form)
    {
        // foreach ($form['tblslaporan'] as $tbls) {

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

            $input = ['1', '3', '5', '7', '9', '2', '4', '6', '8', '10'];
            $output = ['2', '4', '6', '8', '10'];

            $totaljk[] = $this->select('');

            $timeakhir2 = date('Y-m-d', strtotime(' +1 days', strtotime($timeawal)));

            $cekf = $this->select("pegawai.`pegawai_nip` AS idkar, pegawai.`pegawai_nama` AS nama, att_log.`inoutmode` AS inoutm, DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d') AS tgl, DATE_FORMAT(att_log.`scan_date`, '%H:%i') AS cek")
                ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                ->where('pegawai.`pegawai_pin`', $form['idkar'])
                ->where('pegawai.`resign`', '0')
                ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                ->get()->getResultArray();

            $cekinmin = $this->select("pegawai.`pegawai_nip` AS idkar, pegawai.`pegawai_nama` AS nama, att_log.`inoutmode` AS inoutm, MIN(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cekin")
                ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                ->where('pegawai.`pegawai_pin`', $form['idkar'])
                ->where('pegawai.`resign`', '0')
                ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                ->whereIn('att_log.`inoutmode`', $input)
                ->get()->getResultArray();

            $cekoutmax2 = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                ->where('pegawai.`pegawai_pin`', $form['idkar'])
                ->where('pegawai.`resign`', '0')
                ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                ->whereIn('att_log.`inoutmode`', $output)
                ->get()->getResultArray();

            $cekoutmax3 = $this->select("MIN(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                ->where('pegawai.`pegawai_pin`', $form['idkar'])
                ->where('pegawai.`resign`', '0')
                ->where("scan_date BETWEEN '$timeakhir2 00:00:00' AND '$timeakhir2 23:59:59'")
                ->whereIn('att_log.`inoutmode`', $output)
                ->get()->getResultArray();


            if ($form['divisi'] == 'SATPAM') {
                if (date('Hi', strtotime($cekinmin[0]['cekin'])) > '1800') {
                    if (date('Hi', strtotime($cekoutmax3[0]['cout'])) < '0800') {
                        $cekoutmax = $this->select("MIN(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                            ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                            ->where('pegawai.`pegawai_pin`', $form['idkar'])
                            ->where('pegawai.`resign`', '0')
                            ->where("scan_date BETWEEN '$timeakhir2 00:00:00' AND '$timeakhir2 23:59:59'")
                            ->whereIn('att_log.`inoutmode`', $output)
                            ->get()->getResultArray();
                    }
                } else {
                    $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                        ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                        ->where('pegawai.`pegawai_pin`', $form['idkar'])
                        ->where('pegawai.`resign`', '0')
                        ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                        ->whereIn('att_log.`inoutmode`', $output)
                        ->get()->getResultArray();
                }
            } else {
                if (date('Hi', strtotime($cekinmin[0]['cekin'])) > '2100') {
                    $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                        ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                        ->where('pegawai.`pegawai_pin`', $form['idkar'])
                        ->where('pegawai.`resign`', '0')
                        ->where("scan_date BETWEEN '$timeakhir2 00:00:00' AND '$timeakhir2 23:59:59'")
                        ->whereIn('att_log.`inoutmode`', $output)
                        ->get()->getResultArray();
                } else {
                    if (date('Hi', strtotime($cekinmin[0]['cekin'])) > '1400') {
                        if ($cekf['inoutm'] != 'O') {
                            $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                                ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                                ->where('pegawai.`pegawai_pin`', $form['idkar'])
                                ->where('pegawai.`resign`', '0')
                                ->where("scan_date BETWEEN '$timeakhir2 00:00:00' AND '$timeakhir2 23:59:59'")
                                ->whereIn('att_log.`inoutmode`', $output)
                                ->get()->getResultArray();
                        } else {

                            if (date('His', strtotime($cekinmin[0]['cekin'])) > '170000' && $cekf['inoutm'] != 'O') {
                                $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                                    ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                                    ->where('pegawai.`pegawai_pin`', $form['idkar'])
                                    ->where('pegawai.`resign`', '0')
                                    ->where("scan_date BETWEEN '$timeakhir2 00:00:00' AND '$timeakhir2 23:59:59'")
                                    ->whereIn('att_log.`inoutmode`', $output)
                                    ->get()->getResultArray();
                            } else {
                                if (date('Hi', strtotime($cekoutmax2[0]['cout'])) > '1500') {
                                    $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                                        ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                                        ->where('pegawai.`pegawai_pin`', $form['idkar'])
                                        ->where('pegawai.`resign`', '0')
                                        ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                                        ->whereIn('att_log.`inoutmode`', $output)
                                        ->get()->getResultArray();
                                }
                            }
                        }
                    } else {
                        $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                            ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                            ->where('pegawai.`pegawai_pin`', $form['idkar'])
                            ->where('pegawai.`resign`', '0')
                            ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                            ->where('att_log.`inoutmode`', '2')
                            ->orWhere('att_log.`inoutmode`', '4')
                            ->orWhere('att_log.`inoutmode`', '6')
                            ->orWhere('att_log.`inoutmode`', '8')
                            ->orWhere('att_log.`inoutmode`', '10')
                            ->get()->getResultArray();
                    }
                }
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


            $clor = "white";

            $day[] = date('D', strtotime($timeawal));
            $dayi = date('D', strtotime($timeawal));

            // if ($dayi == "Sun") {
            //     $clor = "orange";
            // }

            $masuk = 0;
            $n = 0;
            $tidakmasuk = 0;

            foreach ($form['jkm'] as $jkmk) {

                if ($form['grupt'] == $jkmk['kodejk']) {

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
                        if (date_format($i, 'Y-m-d') === $timeawal) {
                            $tjk = $this->db->query("SELECT jdw_kerja_m.`jdw_kerja_m_kode` AS kodejk, jdw_kerja_d.`jdw_kerja_d_idx` AS idx, jdw_kerja_m.`jdw_kerja_m_periode` AS p, jdw_kerja_m.`jdw_kerja_m_mulai` AS tglta, jdw_kerja_d.`jdw_kerja_d_libur` AS libur, jam_kerja.`jk_bcin` AS smasuk, jam_kerja.`jk_durtime` AS durasi, jam_kerja.`jk_ecout` AS skeluar FROM jdw_kerja_m
                                    JOIN jdw_kerja_d ON jdw_kerja_m.`jdw_kerja_m_id`=jdw_kerja_d.`jdw_kerja_m_id`
                                    LEFT JOIN jam_kerja ON jam_kerja.`jk_id` = jdw_kerja_d.`jk_id`
                                    WHERE jdw_kerja_m.`jdw_kerja_m_kode`='" . $jkmk['kodejk'] . "' AND jdw_kerja_d.`jdw_kerja_d_idx`='$n'")->getRowArray();
                            if ($tjk['libur'] == '0') {
                                if ($timeawal <= $datenow) {
                                    if ($cekinmin[0]['cekin'] == NULL || $cekoutmax[0]['cout'] == NULL) {
                                        $clor = "red";
                                        $tidakmasuk++;
                                        $tm[] = $tidakmasuk;
                                    } else {
                                        $masuk++;
                                        $msk[] = $masuk;
                                    }
                                } else {
                                    $clor = "white";
                                }
                            } else {
                                $clor = "yellow";
                            }
                        }
                        $tanggal[] = date_format($i, 'Y-m-d');
                    }
                }
            }

            $color[] = $clor;

            //jam kerja tetap
            // if ($form['grup'] == $form['grupt'] && $form['day'] == $dayi && $form['kategori'] == '1') {

            //     // 
            // }


            // // jamkerja berulang
            // if ($form['grup'] == $form['grupt'] && $form['day'] == $dayi && $form['kategori'] == '1') {

            //     // 
            // }


            // // jamkerja tertentu
            // if ($form['grup'] == $form['grupt'] && $form['day'] == $dayi && $form['kategori'] == '1') {

            //     // 
            // }


            $finger2[] = $finger;

            $timeawal3[] = $timeawal;
            $timeawal = date('Y-m-d', strtotime('+1 days', strtotime($timeawal)));
        }
        // }
        $alldata[] = [
            'idkar' => $form['idkar'],
            'm' => $mjkn2,
            'nama' => $form['nama'],
            'divisi' => $form['divisi'],
            'unit' => $form['unit'],
            'subunit' => $form['subunit'],
            // 'tanggal' => $tanggal,
            'asal' => $form['asal'],
            'tm' => $tm,
            'msk' => $msk,
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