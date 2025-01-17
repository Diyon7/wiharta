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
        return $this->db->query("SELECT pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_nip` AS idkar, pegawai.`golongan` AS golongan, pembagian2.`pembagian2_nama` AS divisi, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit, pegawai.`grup_jam_kerja` AS grupt, pembagian3.`pembagian3_nama` AS asal, pegawai.`golongan` AS golongan, pegawai.`tgl_mulai_kerja` AS tmt, pegawai.`grup` AS grup FROM pegawai
        LEFT JOIN pembagian2 ON pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`
        LEFT JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        LEFT JOIN pembagian5 ON pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`
        LEFT JOIN pembagian3 ON pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`
        WHERE pembagian3.`pembagian3_nama` LIKE '" . $data['vendor'] . "' AND pegawai.`tgl_mulai_kerja` <= '" . $data['tgl2'] . "' AND pegawai.`pegawai_nip` REGEXP '^[0-9]+$' AND pegawai.`golongan`!='1' AND (tgl_resign >= '" . $data['tgl'] . "' OR tgl_resign IS NULL OR tgl_resign='0000-00-00')")
            ->getResultArray();
        // return $this->select('pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_pin` AS idkar, pegawai.`golongan` AS golongan, pembagian2.`pembagian2_nama` AS divisi, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit, pegawai.`grup_jam_kerja` AS grupt, pembagian3.`pembagian3_nama` AS asal, pegawai.`golongan` AS golongan, pegawai.`tgl_mulai_kerja` AS tmt, pegawai.`grup` AS grup')
        //     ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
        //     ->join('pembagian4', 'pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`')
        //     ->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`')
        //     ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
        //     ->like('pembagian3.`pembagian3_nama`', $data['vendor'])
        //     ->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'")
        //     ->where('pegawai.`golongan`!=', '1')
        //     ->where("(tgl_resign >= '" . $data['tgl'] . "' OR tgl_resign IS NULL)")
        //     ->get()->getResultArray();
    }

    public function Dataabsen($form)
    {
         // foreach ($form['tblslaporan'] as $tbls) {
        $terlambat = 0;
        $pcepat = 0;
        $kelebihanjam = 0;
        
        $cekoutmax = "0000-00-00 00:00:00";

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

            $input = ['1', '3', '5', '7', '9'];
            $output = ['2', '4', '6', '8', '10'];

            $timeakhir2 = date('Y-m-d', strtotime(' +1 days', strtotime($timeawal)));

            $cekinmin = $this->select("MIN(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cekin")
                ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                ->where('pegawai.`pegawai_nip`', $form['idkar'])
                ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                ->whereIn('att_log.`inoutmode`', $input)
                ->get()->getResultArray();

            $cekoutmax2 = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                ->where('pegawai.`pegawai_nip`', $form['idkar'])
                ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                ->whereIn('att_log.`inoutmode`', $output)
                ->get()->getResultArray();
            
            

            // $cekoutmax3 = $this->select("MIN(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
            //     ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
            //     ->where('pegawai.`pegawai_pin`', $form['idkar'])
            //     ->where("scan_date BETWEEN '$timeakhir2 00:00:00' AND '$timeakhir2 23:59:59'")
            //     ->whereIn('att_log.`inoutmode`', $output)
            //     ->get()->getResultArray();
                
                
            $outmin = date('Y-m-d H:i:s', strtotime('+2 hours', strtotime($cekinmin[0]['cekin'])));
            $outmax = date('Y-m-d H:i:s', strtotime('+18 hours', strtotime($cekinmin[0]['cekin'])));
            
             $cekoutmax4 = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                ->where('pegawai.`pegawai_nip`', $form['idkar'])
                ->where("scan_date BETWEEN '$outmin' AND '$outmax'")
                ->whereIn('att_log.`inoutmode`', $output)
                ->get()->getResultArray();
                
             $cekoutmax5 = $this->select("MIN(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                ->where('pegawai.`pegawai_nip`', $form['idkar'])
                ->where("scan_date BETWEEN '2021-01-01 00:00:00' AND '2021-01-01 23:59:59'")
                ->whereIn('att_log.`inoutmode`', $output)
                ->get()->getResultArray();
            
            
            if ($cekoutmax4[0]['inoutm'] == null) {
                if ($cekoutmax2[0]['inoutm'] == null) {
                    $cekoutmax = $cekoutmax5;
                } else {
                    $cekoutmax = $cekoutmax2;
                }
            //     if (date('Hi', strtotime($cekinmin[0]['cekin'])) > '2100') {
            //         $cekoutmax = $cekoutmax3;
            //     } else {
            //         $cekoutmax = $cekoutmax3;
            //     }
            } else {
                $cekoutmax = $cekoutmax4;
            }
            
            // if ($form['unit'] == 'SATPAM') {
            //     if (date('Hi', strtotime($cekinmin[0]['cekin'])) > '1700') {
            //         if (date('Hi', strtotime($cekoutmax3[0]['cout'])) < '0900') {
            //             $cekoutmax = $cekoutmax3;
            //         }
            //     } else {
            //         $cekoutmax = $cekoutmax2;
            //     }
            // } else {
            //     if (date('Hi', strtotime($cekinmin[0]['cekin'])) > '2100') {
            //         $cekoutmax = $cekoutmax3;
            //     } else {
            //         if (date('Hi', strtotime($cekinmin[0]['cekin'])) > '1400') {
            //             if ($cekoutmax2[0]['inoutm'] == null) {
            //                 if (date('Hi', strtotime($cekoutmax3[0]['cout'])) < '0830') {
            //                     $cekoutmax = $cekoutmax3;
            //                 }
            //                 $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
            //                     ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
            //                     ->where('pegawai.`pegawai_pin`', $form['idkar'])
            //                 ->where('pegawai.`resign`', '0')
            //                     ->where("scan_date BETWEEN '$timeakhir2 00:00:00' AND '$timeakhir2 23:59:59'")
            //                     ->whereIn('att_log.`inoutmode`', $output)
            //                     ->get()->getResultArray();
            //             } else {
            //                 if (date('His', strtotime($cekinmin[0]['cekin'])) > '170000' && $cekoutmax2[0]['inoutm'] == null) {
            //                     $cekoutmax = $cekoutmax3;
            //                 } else {
            //                     if (date('Hi', strtotime($cekoutmax2[0]['cout'])) > '1430') {
            //                         $cekoutmax = $cekoutmax2;
            //                     } else {
            //                         if (date('Hi', strtotime($cekoutmax3[0]['cout'])) < '0830') {
            //                             $cekoutmax = $cekoutmax3;
            //                         }
            //                     }
            //                 }
            //             }
            //         } else {
            //             $cekoutmax = $cekoutmax2;
            //         }
            //     }
            // }



            $izincekinmin = $this->select("DATE_FORMAT(tbl_izin.`in`, '%y-%m-%d %H:%i:%s') AS cekin, '1' AS inoutm")
                ->join("tbl_izin", "pegawai.`pegawai_nip`=tbl_izin.`pegawai_nip`")
                ->where("tbl_izin.`pegawai_nip`", $form['idkar'])
                ->where("tbl_izin.`in` LIKE '$timeawal %'")
                ->where('tbl_izin.verified', 'a')
                ->get()->getResultArray();

            $izincekoutmax = $this->select("DATE_FORMAT(tbl_izin.`out`, '%y-%m-%d %H:%i:%s') AS cout, '2' AS inoutm")
                ->join("tbl_izin", "pegawai.`pegawai_nip`=tbl_izin.`pegawai_nip`")
                ->where("tbl_izin.`pegawai_nip`", $form['idkar'])
                ->where("tbl_izin.`in` LIKE '$timeawal %'")
                ->where('tbl_izin.verified', 'a')
                ->get()->getResultArray();
                
            $bjk = $this->db->query("SELECT ganti_jk_pegawai.`tgl_awal` AS tglawal, ganti_jk_pegawai.`tgl_akhir` AS tglakhir, jam_kerja.`jk_bcin` AS smasuk, jam_kerja.`jk_ecout` AS skeluar, pegawai.`pegawai_nip` AS nip FROM ganti_jk_pegawai
                                    JOIN pegawai ON pegawai.`pegawai_nip`=ganti_jk_pegawai.`pegawai_id`
                                    JOIN jam_kerja ON jam_kerja.`jk_id`=ganti_jk_pegawai.`jk_id`
                                    WHERE verifikasi='p' AND ganti_jk_pegawai.`tgl_awal`<='$timeawal' AND ganti_jk_pegawai.`tgl_akhir`>='$timeawal' AND pegawai.`pegawai_nip`='" . $form['idkar'] . "'")->getRowArray();
            
            // $bjk = null;

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


            $clor = "white";

            $day[] = date('D', strtotime($timeawal));
            $dayi = date('D', strtotime($timeawal));

            // if ($dayi == "Sun") {
            //     $clor = "orange";
            // }

            $masuk = 0;
            $tidakmasuk = 0;
            $totalhari = 0;
            $izin = 0;
            // $dftizin = $this->db->query("SELECT pegawai_nip FROM tbl_izin
            //                             WHERE tanggal='$timeawal' AND verified='a' AND pegawai_nip='" . $form['idkar'] . "'")->getRowArray();


            foreach ($form['jkm'] as $jkmk) {
                $n = 0;

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
                        if (date('Y-m-d', strtotime($timeawal)) === date_format($i, 'Y-m-d')) {
                            $tjk = $this->db->query("SELECT jdw_kerja_m.`jdw_kerja_m_kode` AS kodejk, jdw_kerja_d.`jdw_kerja_d_idx` AS idx, jdw_kerja_m.`jdw_kerja_m_periode` AS p, jdw_kerja_m.`jdw_kerja_m_mulai` AS tglta, jdw_kerja_d.`jdw_kerja_d_libur` AS libur, jam_kerja.`jk_bcin` AS smasuk, jam_kerja.`jk_durtime` AS durasi, jam_kerja.`jk_ecout` AS skeluar FROM jdw_kerja_m
                                    JOIN jdw_kerja_d ON jdw_kerja_m.`jdw_kerja_m_id`=jdw_kerja_d.`jdw_kerja_m_id`
                                    LEFT JOIN jam_kerja ON jam_kerja.`jk_id` = jdw_kerja_d.`jk_id`
                                    WHERE jdw_kerja_m.`jdw_kerja_m_kode`='" . $jkmk['kodejk'] . "' AND jdw_kerja_d.`jdw_kerja_d_idx`='" . $n . "'")->getRowArray();
                                    
                            $jadwalaktif = $tjk['libur'];
                                    
                            if ($jadwalaktif === '0') {
                                // if ($dftizin['pegawai_nip'] != null) {
                                //     $clor = "green";
                                //     $izin++;
                                //     $izinf[] = $izin;
                                // } else {
                                if ($timeawal <= $datenow) {
                                    $totalhari++;
                                    if ($cekinmin[0]['cekin'] == NULL || $cekoutmax[0]['cout'] == NULL) {
                                        $clor = "red";
                                        $tidakmasuk++;
                                        $tm[] = $tidakmasuk;
                                    } else {
                                        if ($bjk != null) {
                                            $cmasuk = $bjk['smasuk'];
                                            $ckeluar = $bjk['skeluar'];
                                        } else {
                                            $cmasuk = $tjk['smasuk'];
                                            $ckeluar = $tjk['skeluar'];
                                        }
                                        $clor = "white";
                                        $wk = strtotime(date('H:i', strtotime($cekinmin[0]['cekin'])))  - strtotime(date('H:i', strtotime($cmasuk)));
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
                                        } elseif ($toterlambat <= 420) {
                                            $clor = "orange";
                                            $terlambat = $terlambat + 7;
                                        } elseif ($toterlambat <= 480) {
                                            $clor = "orange";
                                            $terlambat = $terlambat + 8;
                                        } elseif ($toterlambat <= 540) {
                                            $clor = "orange";
                                            $terlambat = $terlambat + 9;
                                        }

                                        $ak = strtotime(date('H:i', strtotime($ckeluar))) - strtotime(date('H:i', strtotime($cekoutmax[0]['cout'])));
                                        $lcepat = floor($ak  / 60);
                                        if ($lcepat <= 0) {
                                            $pcepat = $pcepat + 0;
                                        } elseif ($lcepat <= 60) {
                                            $clor = "orange";
                                            $pcepat = $pcepat + 1;
                                        } elseif ($lcepat <= 120) {
                                            $clor = "orange";
                                            $pcepat = $pcepat + 2;
                                        } elseif ($lcepat <= 180) {
                                            $clor = "orange";
                                            $pcepat = $pcepat + 3;
                                        } elseif ($lcepat <= 240) {
                                            $clor = "orange";
                                            $pcepat = $pcepat + 4;
                                        } elseif ($lcepat <= 300) {
                                            $clor = "orange";
                                            $pcepat = $pcepat + 5;
                                        } elseif ($lcepat <= 360) {
                                            $clor = "orange";
                                            $pcepat = $pcepat + 6;
                                        }

                                        $kj = (strtotime(date('H:i', strtotime($cekoutmax[0]['cout']))))  - (strtotime(date('H:i', strtotime($ckeluar))));
                                        $tokelebih = floor($kj  / 60);
                                        if ($tokelebih >= 540) {
                                            $clor = "grey";
                                            $kelebihanjam = $kelebihanjam + 9;
                                        } elseif ($tokelebih >= 480) {
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
                                        // // $thr[] = $totalhari;
                                        // if ($totalhari > $jkmk['jdwtagihan']) {
                                        //     $masuk2 = $totalhari - $jkmk['jdwtagihan'];
                                        //     $masuk = $masuk2;
                                        // }
                                        $msk[] = $masuk;
                                    }
                                } else {
                                    $clor = "white";
                                }
                                // }
                            } else {
                                $clor = "yellow";
                            }
                        } else {
                            $none = [];
                        }
                        $tanggal[] = $n;
                        $bjk = $bjk;
                    }
                }
            }
            
            if (strtotime($cekinmin[0]['cekin']) > strtotime($cekoutmax[0]['cout'])) {
                $clor = "black";
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

            $tpc = $pcepat;
            $trt = $terlambat;

            $kbhnj = $kelebihanjam;
            $finger2[] = $finger;

            // $timeawal3[] = $timeawal;
            $timeawal = date('Y-m-d', strtotime('+1 days', strtotime($timeawal)));
        }
        // }
        $alldata[] = [
            'idkar' => $form['idkar'],
            // 'timeawal3' => $timeawal3,
            'pcepat' => $tpc,
            'terlambat' => $trt,
            'kelebihanjam' => $kbhnj,
            // 'thr' => $thr,
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
            // 'jabatan' => $form['jabatan'],
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
