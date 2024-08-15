<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Absensi_model;
use App\Models\Pegawai_Model;
use App\Models\Jabatan_model;
use App\Models\Divisi_model;
use App\Models\Jnsizin_model;
use App\Models\Tblizin_model;
use App\Models\Unit_model;
use App\Models\Subunit_model;
use App\Models\Jamkerja_model;
use App\Models\Jamkerjaubah_model;
use App\Models\Vendor_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Jamkerja extends BaseController
{

    protected $pegawaimodel;
    protected $jabatan;
    protected $divisi;
    protected $jnsizin;
    protected $tblizin;
    protected $unitmodel;
    protected $subunit;
    protected $vendormodel;
    protected $jamkerja;
    protected $jamkerjaubah;
    protected $view;
    protected $absensi;

    public function __construct()
    {
        $this->pegawaimodel = new Pegawai_Model();
        $this->jabatan = new Jabatan_model();
        $this->divisi = new Divisi_model();
        $this->jnsizin = new Jnsizin_model();
        $this->tblizin = new Tblizin_model();
        $this->unitmodel = new Unit_model();
        $this->subunit = new Subunit_model();
        $this->jamkerja = new Jamkerja_model();
        $this->jamkerjaubah = new Jamkerjaubah_model();
        $this->vendormodel = new Vendor_model();
        $this->absensi = new Absensi_model();
    }

    public function Index()
    {

        $daftarkaryawanjp3 = $this->pegawaimodel->Daftarkaryawanajp3();
        $djnsizin = $this->jnsizin->findAll();
        $shfjamkerja = $this->jamkerja->findAll();

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'ganti shift',
            'daftarkaryawanjp3' => $daftarkaryawanjp3,
            'jnsizin' => $djnsizin,
            'jam_kerja' => $shfjamkerja
        ];

        return view('izin/index', $data);
    }
    
    public function gantishift()
    {
        
        if(in_groups('vendor')) {
            $vendor = user()->username;
        } else {
            $vendor = "%";
        }
        
        $namakaryawan = $this->pegawaimodel->Daftarkaryawan($vendor);
        $jamkerja = $this->jamkerja->findAll();
        
        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Ganti Shift',
            'nama' => $namakaryawan,
            'jamkerja' => $jamkerja
        ];

        return view('jamkerja/gantishift', $data);
    }
    
    public function Validasi()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Validasi Ganti Shift'
        ];

        return view('jamkerja/verifikasi', $data);
    }
    
    public function tambahgantishift()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'tgl' => [
                        'label'  => 'tgl',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Tanggal harus dipilih !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $tgl = $this->request->getPost('tgl');
                    $nama = $this->request->getPost('nama');
                    $shift = $this->request->getPost('shift');
                    $keterangan = $this->request->getPost('keterangan');
                    
                    $tglp = explode(' - ', $tgl);
                    
                    $user = user()->username;
                    
                    $tglm = date('Y-m-d', strtotime($tglp[0]));
                    $tgls = date('Y-m-d', strtotime($tglp[1]));
                    
                    $ubahshift = [
                            'pegawai_id' => $nama,
                            'tgl_awal' => $tglm,
                            'tgl_akhir' => $tgls,
                            'jk_id' => $shift,
                            'keterangan' => $keterangan,
                            'verifikasi' => 'p',
                            'namauser' => $user
                        ];
    
                    $save = $this->jamkerjaubah->insert($ubahshift);
                    
                    if ($save) {
                        $msg = [
                            'success' => 'berhasil',
                        ];
                    } else {
                        $msg = [
                            'error' => 'data error'
                        ];
                    }
                } else {
                    $msg = [
                        'coba' => $tgl,
                        'error' => $this->validator->listErrors()
                    ];
                }
                echo json_encode($msg);
            }
        }
    }
    
    public function Deletegantishift()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $idgantijkerja = htmlspecialchars($this->request->getPost('idgantishift'));

            if ($idgantijkerja) {
                $delete = $this->jamkerjaubah->delete($idgantijkerja);
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }
    
    public function Datatablesgantijamkerja() {
        $request = Services::request();
        $jamkerja = new Jamkerjaubah_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $jamkerja->get_datatablesjamkerja();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $dkaryawan) {
                $no++;
                $row = [];
                $row[] = $dkaryawan->nama;
                $row[] = $dkaryawan->tgl_awal;
                $row[] = $dkaryawan->tgl_akhir;
                $row[] = $dkaryawan->shift;
                $row[] = $dkaryawan->keterangan;
                $prosesv = $dkaryawan->verifikasi;
                if ($prosesv == 's') {
                        $row[] = "Diterima";
                } elseif ($prosesv == 'p') {
                    $row[] = "Proses Pengajuan";
                } else {
                    $row[] = 'Ditolak';
                }
                $row[] = "<a class=\"btn btn-danger btn-delete btn-sm\" data-idgantishift=\"$dkaryawan->ganti_jk_id\">Delete</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $jamkerja->count_alljamkerja(),
                "recordsFiltered" => $jamkerja->count_filteredjamkerja(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
    
    public function Formjamkerja()
    {
        $request = Services::request();
        $jamkerja = new Jamkerjaubah_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $jamkerja->get_datatablespjamkerja();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->pegawai_id;
                $row[] = $gs->nama;
                $row[] = $gs->shift;
                $row[] = $gs->tgl_awal;
                $row[] = $gs->tgl_akhir;
                $row[] = $gs->keterangan;
                $row[] = "<a class=\"btn btn-danger btn-delete btn-sm\" data-deleteizin=\"$gs->pegawai_id\">Delete</a> <a class=\"btn btn-danger btn-ubahbt btn-sm\" data-ubahbtizin=\"$gs->pegawai_id\">Tolak</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $jamkerja->count_allpjamkerja(),
                "recordsFiltered" => $jamkerja->count_filteredpjamkerja(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Formpjamkerja()
    {
        $request = Services::request();
        $jamkerja = new Tblizin_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $jamkerja->get_datatablesjamkerjab();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
               $row[] = $gs->pegawai_id;
                $row[] = $gs->nama;
                $row[] = $gs->shift;
                $row[] = $gs->tgl_awal;
                $row[] = $gs->tgl_akhir;
                $row[] = $gs->keterangan;
                $row[] = "<a onclick=\"ubahbsdata('$gs->createdat')\" class=\"btn btn-danger btn-ubahbs btn-sm\" data-ubahbsizin=\"$gs->idtblizin\">Verifikasi</a><a onclick=\"ubahbtdata('$gs->createdat')\" class=\"btn btn-danger btn-ubahbt btn-sm\" data-ubahbtizin=\"$gs->idtblizin\">Tolak</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $jamkerja->count_alljamkerjab(),
                "recordsFiltered" => $jamkerja->count_filteredpjamkerjab(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
    public function Formtjamkerja()
    {
        $request = Services::request();
        $jamkerja = new Tbljamkerja_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $jamkerja->get_datatablesjamkerjac();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->pegawai_id;
                $row[] = $gs->nama;
                $row[] = $gs->shift;
                $row[] = $gs->tgl_awal;
                $row[] = $gs->tgl_akhir;
                $row[] = $gs->keterangan;
                $row[] = "<a onclick=\"hapusdata('$gs->createdat')\" class=\"btn btn-danger btn-delete btn-sm\" data-deleteizin=\"$gs->idtblizin\">Delete</a><a onclick=\"ubahbsdata('$gs->createdat')\" class=\"btn btn-danger btn-ubahbs btn-sm\" data-ubahbsizin=\"$gs->idtblizin\">Verifikasi</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $jamkerja->count_alljamkerjac(),
                "recordsFiltered" => $jamkerja->count_filteredjamkerjac(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
    
}