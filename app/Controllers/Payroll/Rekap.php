<?php

namespace App\Controllers\Payroll;

use App\Models\Diliburkan_model;
use App\Controllers\BaseController;
use App\Models\Pegawai_Model;
use App\Models\Jabatan_model;
use App\Models\Divisi_model;
use App\Models\RekapAll_model;
use App\Models\Unit_model;
use App\Models\Subunit_model;
use App\Models\Vendor_model;

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

    // public function Printrekapunit()
    // {
    //     if ($this->request->isAJAX()) {

    //         $tanggal = $this->request->getPost('tglno');

    //         $dkpharian = $this->rekapall->DKPHarian($tanggal);
    //         $dkpmasuk = $this->rekapall->DKPMasuk($tanggal);

    //         $stm = $this->rekapall->TidakmasukNS1($tanggal);
    //         $sm = $this->rekapall->TidakmasukNS2($tanggal);
    //         $s1 = $this->rekapall->Shift1($tanggal);
    //         $s2 = $this->rekapall->Shift2($tanggal);
    //         $s3 = $this->rekapall->Shift3($tanggal);

    //         $tnss = $this->rekapall->TerlambatNS1($tanggal);
    //         $tnsd = $this->rekapall->TerlambatNS2($tanggal);

    //         $data = [
    //             'dkpharian' => $dkpharian,
    //             'dkpmasuk' => $dkpmasuk,
    //             'stm' => $stm,
    //             // 'sm' => $sm,
    //             's1' => $s1,
    //             's2' => $s2,
    //             's3' => $s3,
    //             'tnss' => $tnss,
    //             'tnsd' => $tnsd,
    //             'tanggal' => $tanggal
    //         ];

    //         $tampiltabel = [
    //             'sukses' => view('rekap/exportexcel', $data)
    //         ];

    //         echo json_encode($tampiltabel);
    //     }
    // }

    public function Tabelabsenlaporanharian()
    {
        // if ($this->request->isAJAX()) {

        $postday = $this->request->getPost('tgl');

        $tglt = date('m/26', strtotime(date($postday) . '- 1 month'));

        $data = [
            'tglt' => $tglt,
            'tanggal' => $postday,
            'divisi' => $this->request->getPost('divisi')
        ];

        $dkpharianpembagian2 = $this->rekapall->DKPharianpembagian2($data);

        // $rdiliburkan[] = $this->diliburkan->where('tgl_d', $datadkp['tanggal'])->findAll();
        foreach ($dkpharianpembagian2 as $qu) {
            $datas = [
                'tglt' => $tglt,
                'tanggal' => $postday,
                'divisi' => $this->request->getPost('divisi'),
                'qu' => $qu['pembagian4_id']
            ];
            $dkpharian[] = $this->rekapall->DKPHarian($datas);
        }
        // $dkpmasuk = $this->rekapall->DKPMasuk($data);

        $stm = $this->rekapall->TidakmasukNS1($data);
        $sm = $this->rekapall->TidakmasukNS2($data);
        $s1 = $this->rekapall->Shift1($data);
        $s2 = $this->rekapall->Shift2($data);
        $s3 = $this->rekapall->Shift3($data);

        // $dkpharian = $dkpharian + $dkpmasuk;

        $tnss = array_merge($this->rekapall->TerlambatNS1($data), $this->rekapall->TerlambatNS2($data));
        $tnsd = $this->rekapall->TerlambatNS2($data);

        $data = [
            // 'rdiliburkan' => $rdiliburkan,
            'dkpharian' => $dkpharian,
            'dkpharianpembagian2' => $dkpharianpembagian2,
            // 'dkpmasuk' => $dkpmasuk,
            'stm' => $stm,
            'sm' => $sm,
            's1' => $s1,
            's2' => $s2,
            's3' => $s3,
            'tnss' => $tnss,
            'tnsd' => $tnsd,
            'data' => $data
        ];

        // $tampiltabel = [
        return view('rekap/tabelharian', $data);
        // ];

        // echo json_encode($tampiltabel);
        // }
    }
}
