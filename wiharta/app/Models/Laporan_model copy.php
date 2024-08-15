<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Laporan_model extends Model
{
    protected $table      = 'pegawai';
    protected $primaryKey = 'pegawai_id';

    protected $allowedFields = ['pegawai_pin', 'pegawai_nip', 'pegawai_id', 'pegawai_nama', 'tgl_lahir', 'tgl_mulai_kerja', 'tgl_masuk_pertama', 'golongan', 'grup', 'grup_t', 'grup_jam_kerja', 'resign'];

    protected $request;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function Alllaporan($vendor)
    {
        return $this->select('pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_nip` AS idkar, pegawai.`golongan` AS golongan, pembagian2.`pembagian2_nama` AS divisi, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit, pembagian3.`pembagian3_nama` AS asal, pegawai.`golongan` AS golongan, pegawai.`tgl_mulai_kerja` AS tmt, pegawai.`grup` AS grup')
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
        foreach ($form['tblslaporan'] as $tbls) {
            $timeawal = $form['timeawal'];
            $timeakhir = $form['timeakhir'];
            $idkar2[] = $tbls['idkar'];
            $tglt = $form['tglt'];
            $idkar = $tbls['idkar'];
            for ($a = $form['tagihanawal']; $a <= $form['tagihanakhir']; $a->modify('+ 1 day')) {
                $tgllaporan[] = $tglt;
                $tglt = date('m/d', strtotime(' +1 days', strtotime($tglt)));

                $input = ['1', '3', '5', '7', '9'];

                $timeakhir2 = date('Y-m-d', strtotime(' +1 days', strtotime($timeawal)));

                $cekin[] = $this->select("pegawai.`pegawai_nip` AS idkar, pegawai.`pegawai_nama` AS nama, att_log.`inoutmode` AS inoutm, DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d') AS tgl, DATE_FORMAT(att_log.`scan_date`, '%H:%i') AS cek")
                    ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                    ->where('pegawai.`pegawai_pin`', $idkar)
                    ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                    ->whereIn('att_log.`inoutmode`', '1')
                    ->orWhere('att_log.`inoutmode`', '3')
                    ->orWhere('att_log.`inoutmode`', '5')
                    ->orWhere('att_log.`inoutmode`', '7')
                    ->orWhere('att_log.`inoutmode`', '9')
                    ->get()->getResultArray();

                $cekinmin = $this->select("pegawai.`pegawai_nip` AS idkar, pegawai.`pegawai_nama` AS nama, att_log.`inoutmode` AS inoutm, MIN(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cekin")
                    ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                    ->where('pegawai.`pegawai_pin`', $idkar)
                    ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                    ->whereIn('att_log.`inoutmode`', $input)
                    ->get()->getResultArray();

                $cekinmin2[] = $this->select("pegawai.`pegawai_nip` AS idkar, pegawai.`pegawai_nama` AS nama, att_log.`inoutmode` AS inoutm, MIN(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cekin")
                    ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                    ->where('pegawai.`pegawai_pin`', $idkar)
                    ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                    ->whereIn('att_log.`inoutmode`', $input)
                    ->get()->getResultArray();

                if ($tbls['divisi'] == 'SATPAM') {
                    if (date('Hi', strtotime($cekinmin[0]['cekin'])) > '1800') {
                        $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                            ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                            ->where('pegawai.`pegawai_pin`', $idkar)
                            ->where("scan_date BETWEEN '$timeakhir2 00:00:00' AND '$timeakhir2 23:59:59'")
                            ->where('att_log.`inoutmode`', '2')
                            ->orWhere('att_log.`inoutmode`', '4')
                            ->orWhere('att_log.`inoutmode`', '6')
                            ->orWhere('att_log.`inoutmode`', '8')
                            ->orWhere('att_log.`inoutmode`', '10')
                            ->get()->getResultArray();
                    } else {
                        $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                            ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                            ->where('pegawai.`pegawai_pin`', $idkar)
                            ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                            ->where('att_log.`inoutmode`', '2')
                            ->orWhere('att_log.`inoutmode`', '4')
                            ->orWhere('att_log.`inoutmode`', '6')
                            ->orWhere('att_log.`inoutmode`', '8')
                            ->orWhere('att_log.`inoutmode`', '10')
                            ->get()->getResultArray();
                    }
                } else {
                    if (date('Hi', strtotime($cekinmin[0]['cekin'])) > '2100') {
                        $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                            ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                            ->where('pegawai.`pegawai_pin`', $idkar)
                            ->where("scan_date BETWEEN '$timeakhir2 00:00:00' AND '$timeakhir2 23:59:59'")
                            ->where('att_log.`inoutmode`', '2')
                            ->orWhere('att_log.`inoutmode`', '4')
                            ->orWhere('att_log.`inoutmode`', '6')
                            ->orWhere('att_log.`inoutmode`', '8')
                            ->orWhere('att_log.`inoutmode`', '10')
                            ->get()->getResultArray();
                    } else {
                        if (date('Hi', strtotime($cekinmin[0]['cekin'])) > '1400') {
                            if ($cekin['inoutm'] != 'O') {
                            } else {
                                if (date('His', strtotime($cekinmin[0]['cekin'])) > '170000') {
                                    $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                                        ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                                        ->where('pegawai.`pegawai_pin`', $idkar)
                                        ->where("scan_date BETWEEN '$timeakhir2 00:00:00' AND '$timeakhir2 23:59:59'")
                                        ->where('att_log.`inoutmode`', '2')
                                        ->orWhere('att_log.`inoutmode`', '4')
                                        ->orWhere('att_log.`inoutmode`', '6')
                                        ->orWhere('att_log.`inoutmode`', '8')
                                        ->orWhere('att_log.`inoutmode`', '10')
                                        ->get()->getResultArray();
                                } else {
                                    $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                                        ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                                        ->where('pegawai.`pegawai_pin`', $idkar)
                                        ->where("scan_date BETWEEN '$timeawal 00:00:00' AND '$timeawal 23:59:59'")
                                        ->where('att_log.`inoutmode`', '2')
                                        ->orWhere('att_log.`inoutmode`', '4')
                                        ->orWhere('att_log.`inoutmode`', '6')
                                        ->orWhere('att_log.`inoutmode`', '8')
                                        ->orWhere('att_log.`inoutmode`', '10')
                                        ->get()->getResultArray();
                                }
                            }
                        } else {
                            $cekoutmax = $this->select("MAX(DATE_FORMAT(att_log.`scan_date`, '%y-%m-%d %H:%i:%s')) AS cout, att_log.`inoutmode` AS inoutm")
                                ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`', 'right')
                                ->where('pegawai.`pegawai_pin`', $idkar)
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
                    $finger = ' ckin ';
                } else {
                    $finger = ' I : ' . date('H:i', strtotime($cekinmin[0]['cekin']));
                }

                if ($cekoutmax[0]['cout'] == NULL) {
                    $finger .= ' ckout ';
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
                $finger2[] = $finger;

                $timeawal = date('Y-m-d', strtotime('+1 days', strtotime($timeawal)));
                $timeawal3[] = $timeawal;
            }
        }
        $alldata[] = [
            'idkar' => $idkar2,
            'tgllaporan' => $tgllaporan,
            'cekinmin' => $timeawal3,
            'finger' => $finger2
        ];
        return $alldata;
    }
}