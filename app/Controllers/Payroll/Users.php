<?php

namespace App\Controllers\Payroll;

use App\Controllers\BaseController;
use App\Models\Pegawai_Model;
use App\Models\Jabatan_model;
use App\Models\Divisi_model;
use App\Models\Unit_model;
use App\Models\Subunit_model;
use App\Models\Vendor_model;
use Config\Services;
use App\Models\Logkaryawan_model;

class Users extends BaseController
{

    protected $pegawaimodel;
    protected $jabatan;
    protected $divisi;
    protected $unitmodel;
    protected $subunit;
    protected $vendormodel;
    protected $cekaksesuser;

    public function __construct()
    {
        $this->pegawaimodel = new Pegawai_Model();
        $this->jabatan = new Jabatan_model();
        $this->divisi = new Divisi_model();
        $this->unitmodel = new Unit_model();
        $this->subunit = new Subunit_model();
        $this->vendormodel = new Vendor_model();
        // $this->$cekaksesuser = Cekaksesuser();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Karyawan',
        ];

        return view('karyawan/index', $data);
    }

    public function tambahkaryawanjp3()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $vendor = $this->vendormodel->findAll();
            $jabatan = $this->jabatan->findAll();
            $divisi = $this->divisi->findAll();
            $unit = $this->unitmodel->findAll();
            $subunit = $this->subunit->findAll();

            $data = [
                'vendor' => $vendor,
                'jabatan' => $jabatan,
                'divisi' => $divisi,
                'unit' => $unit,
                'subunit' => $subunit,
            ];

            $msg = [
                'sukses' => view('karyawan/tambahpegawaijp3', $data)
            ];

            echo json_encode($msg);
        }
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

    public function Datatableslogkaryawan()
    {
        $request = Services::request();
        $logkaryawan = new Logkaryawan_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $logkaryawan->get_datatableskaryawanajp3();
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
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $logkaryawan->count_allkaryawanajp3(),
                "recordsFiltered" => $logkaryawan->count_filteredkaryawanajp3(),
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

    public function Logkaryawan()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Karyawan'
        ];

        return view('karyawan/logkaryawan', $data);
    }
}
