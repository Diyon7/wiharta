<?php

namespace App\Controllers;

use App\Models\Diliburkan_model;
use App\Controllers\BaseController;
use App\Models\Pegawai_Model;
use App\Models\Jabatan_model;
use App\Models\Divisi_model;
use App\Models\RekapAll_model;
use App\Models\Unit_model;
use App\Models\Subunit_model;
use App\Models\Vendor_model;
use \DateTime;
use Config\Services;

class Rekap extends BaseController
{

    protected $diliburkan;
    protected $pegawaimodel;
    protected $jabatan;
    protected $rekapall;
    protected $divisi;
    protected $unitmodel;
    protected $subunit;
    protected $vendormodel;

    public function __construct()
    {
        $this->diliburkan = new Diliburkan_model();
        $this->pegawaimodel = new Pegawai_Model();
        $this->jabatan = new Jabatan_model();
        $this->divisi = new Divisi_model();
        $this->rekapall = new RekapAll_model();
        $this->unitmodel = new Unit_model();
        $this->subunit = new Subunit_model();
        $this->vendormodel = new Vendor_model();
    }

    public function Index()
    {

        $divisi = $this->divisi->findAll();

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Dashboard SDM',
            'halaman' => 'Laporan Harian',
            'divisi' => $divisi
        ];

        return view('rekap/cekabsen', $data);
    }

    public function Printrekapunit()
    {
        if ($this->request->isAJAX()) {

            $tanggal = $this->request->getPost('tglno');

            $dkpharian = $this->rekapall->DKPHarian($tanggal);
            $dkpmasuk = $this->rekapall->DKPMasuk($tanggal);

            $stm = $this->rekapall->TidakmasukNS1($tanggal);
            $sm = $this->rekapall->TidakmasukNS2($tanggal);
            $s1 = $this->rekapall->Shift1($tanggal);
            $s2 = $this->rekapall->Shift2($tanggal);
            $s3 = $this->rekapall->Shift3($tanggal);

            $tnss = $this->rekapall->TerlambatNS1($tanggal);
            $tnsd = $this->rekapall->TerlambatNS2($tanggal);

            $data = [
                'dkpharian' => $dkpharian,
                'dkpmasuk' => $dkpmasuk,
                'stm' => $stm,
                // 'sm' => $sm,
                's1' => $s1,
                's2' => $s2,
                's3' => $s3,
                'tnss' => $tnss,
                'tnsd' => $tnsd,
                'tanggal' => $tanggal
            ];

            $tampiltabel = [
                'sukses' => view('rekap/exportexcel', $data)
            ];

            echo json_encode($tampiltabel);
        }
    }

    public function Tabelabsenlaporanharian()
    {
        if ($this->request->isAJAX()) {

            $datastatu = $this->request->getPost('status');

            if ($datastatu == "OS") {
                $statusquery = "pegawai.`pegawai_nip` REGEXP '^[0-9]+$'";
            } elseif ($datastatu == "WH") {
                $statusquery = "LEFT(pegawai_nip,1) NOT REGEXP '^[0-9]+$'";
            } elseif ($datastatu == "%") {
                $statusquery = "pegawai.`pegawai_nip` LIKE '%'";
            }
            
            $tanggal = $this->request->getPost('tgl');

            $data = [
                'tanggal' => $tanggal,
                'divisi' => $this->request->getPost('divisi'),
                'status' => $statusquery
            ];




            $rdiliburkan = $this->diliburkan->where('tgl_d', $data['tanggal'])->findAll();
            $dkpharian = $this->rekapall->DKPHarian($data);
            $dkpmasuk = $this->rekapall->DKPMasuk($data);

            $stm = $this->rekapall->TidakmasukNS1($data);
            $sm = $this->rekapall->TidakmasukNS2($data);
            $s1 = $this->rekapall->Shift1($data);
            $s2 = $this->rekapall->Shift2($data);
            $s3 = $this->rekapall->Shift3($data);

            $tnss = array_merge($this->rekapall->TerlambatNS1($data), $this->rekapall->TerlambatNS2($data));
            // $tnsd = $this->rekapall->TerlambatNS2($data);

            $data = [
                'rdiliburkan' => $rdiliburkan,
                'dkpharian' => $dkpharian,
                'dkpmasuk' => $dkpmasuk,
                'stm' => $stm,
                'sm' => $sm,
                's1' => $s1,
                's2' => $s2,
                's3' => $s3,
                'tnss' => $tnss,
                // 'tnsd' => $tnsd,
                'data' => $data,
                'status' => $datastatu,
                'tanggal' => $tanggal
            ];

            $tampiltabel = [
                'sukses' => view('rekap/tabelharian', $data)
            ];

            echo json_encode($tampiltabel);
        }
    }
    
    public function Detaildataunit() {
        if ($this->request->isAJAX()) {

            $unit = $this->request->getPost('unit');
            $tanggal = $this->request->getPost('tanggal');
            
            $datastatu = $this->request->getPost('status');

            if ($datastatu == "OS") {
                $statusquery = "pegawai.`pegawai_nip` REGEXP '^[0-9]+$'";
            } elseif ($datastatu == "WH") {
                $statusquery = "LEFT(pegawai_nip,1) NOT REGEXP '^[0-9]+$'";
            } elseif ($datastatu == "%") {
                $statusquery = "pegawai.`pegawai_nip` LIKE '%'";
            }
            
            $isidatabase = [
                    'tanggal' => $tanggal,
                    'status' => $statusquery,
                    'unit' => $unit,
                ];
                
                $data = [
                    'unit' => $unit,
                    'tanggal' => $tanggal,
                    'data' => $this->rekapall->Detailunit($isidatabase)
                ];

            $msg = [
                'sukses' => view('rekap/detailunitharian', $data)
            ];

            echo json_encode($msg);
        }
    }
}
