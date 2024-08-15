<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pegawai_Model;
use App\Models\Laporan_model;
use App\Models\Jabatan_model;
use App\Models\Divisi_model;
use App\Models\Unit_model;
use App\Models\Jadwalkerja_model;
use App\Models\Subunit_model;
use App\Models\Vendor_model;
use \DateTime;
use Config\Services;

class Laporan extends BaseController
{

    protected $pegawaimodel;
    protected $laporanmodel;
    protected $jabatan;
    protected $divisi;
    protected $unitmodel;
    protected $jadwalkerjamodel;
    protected $subunit;
    protected $vendormodel;

    public function __construct()
    {
        $this->pegawaimodel = new Pegawai_Model();
        $this->laporanmodel = new Laporan_model();
        $this->jabatan = new Jabatan_model();
        $this->divisi = new Divisi_model();
        $this->unitmodel = new Unit_model();
        $this->jadwalkerjamodel = new Jadwalkerja_model();
        $this->subunit = new Subunit_model();
        $this->vendormodel = new Vendor_model();
    }

    public function Detailakaryawanjp3()
    {
        if ($this->request->isAJAX()) {
            $nippegaw = $this->request->getPost('idnip');

            $detailkarya = $this->pegawaimodel->detailkaryawana($nippegaw);

            $data = [
                'detailkaryawana' => $detailkarya
            ];
            $msg = [
                'sukses' => view('karyawan/detail', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Laporanbulanan()
    {

        $vendor = $this->vendormodel->findAll();
        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Dashboard SDM',
            'halaman' => 'Laporan Bulanan',
            'vendor' => $vendor

        ];

        return view('laporan/bulanan', $data);
    }

    public function Tabelabsenlaporanbulanan()
    {
        if ($this->request->isAJAX()) {


            $vendor = $this->request->getPost('vendor');
            $tblalllaporan = $this->laporanmodel->Alllaporan($vendor);


            $vendorall = $this->vendormodel->findAll();

            $bulan2 = $this->request->getPost('tgl');
            $tglt = date('m/26', strtotime(date($bulan2) . '- 1 month'));
            foreach ($tblalllaporan as $tbls) {
                $bulan = $this->request->getPost('tgl');

                $jkm = $this->jadwalkerjamodel->Jadwalkerjanormal();

                $timeawal = date('Y-m-26', strtotime(date($bulan) . '- 1 month'));
                $timeakhir = date('Y-m-25', strtotime(date($bulan) . '- 0 month'));

                $tagihanawal = new DateTime($timeawal);
                $tagihanakhir = new DateTime($timeakhir);
                $form = [
                    'bulan' => $bulan,
                    'vendor' => $vendor,
                    'idkar' => $tbls['idkar'],
                    'divisi' => $tbls['divisi'],
                    'jkm' => $jkm,
                    'nama' => $tbls['nama'],
                    'golongan' => $tbls['golongan'],
                    'unit' => $tbls['unit'],
                    'subunit' => $tbls['subunit'],
                    'asal' => $tbls['asal'],
                    'tmt' => $tbls['tmt'],
                    'grup' => $tbls['grup'],
                    'grupt' => $tbls['grupt'],
                    'timeawal' => $timeawal,
                    'timeakhir' => $timeakhir,
                    'tagihanawal' => $tagihanawal,
                    'tagihanakhir' => $tagihanakhir,
                    'tglt' => $tglt,
                    'tblslaporan' => $tblalllaporan,
                    'tbls' => $tbls
                ];
                $tbldataabsen[] = $this->laporanmodel->Dataabsen($form);
            }
            $data = [
                'vendor' => $vendorall,
                'bulan' => $bulan,
                'tagihanawal' => $tagihanawal,
                'tagihanakhir' => $tagihanakhir,
                'tglt' => $tglt,
                'jkm' => $jkm,
                'tblalllaporan' => $tblalllaporan,
                'tbldataabsen' => $tbldataabsen
            ];

            $tampiltabel = [
                'sukses' => view('laporan/tabelbulanan', $data)
            ];

            echo json_encode($tampiltabel);
        }
    }

    public function Datatablesjp3a()
    {
        $request = Services::request();
        $pegawaimodel = new Pegawai_Model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $pegawaimodel->get_datatableskaryawanajp3();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $karyawana) {
                $no++;
                $row = [];
                $row[] = $karyawana->idkar;
                $row[] = $karyawana->vendor;
                $row[] = $karyawana->nama;
                $row[] = $karyawana->bagian;
                $row[] = $karyawana->tmt;
                $row[] = $karyawana->grup_t;
                $row[] = "<a onclick=\"detailkaryawana('$karyawana->idkar')\" class=\"btn btn-success\">Detail</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $pegawaimodel->count_allkaryawanajp3(),
                "recordsFiltered" => $pegawaimodel->count_filteredkaryawanajp3(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
    public function Datatablesjp3k()
    {
        $request = Services::request();
        $pegawaimodel = new Pegawai_Model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $pegawaimodel->get_datatableskaryawankjp3();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $karyawana) {
                $no++;
                $row = [];
                $row[] = $karyawana->idkar;
                $row[] = $karyawana->vendor;
                $row[] = $karyawana->nama;
                $row[] = $karyawana->bagian;
                $row[] = $karyawana->tmt;
                $row[] = $karyawana->grup_t;
                $row[] = "<button class=\"btn btn-success\">Detail</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $pegawaimodel->count_allkaryawankjp3(),
                "recordsFiltered" => $pegawaimodel->count_filteredkaryawankjp3(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}