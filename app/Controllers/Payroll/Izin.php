<?php

namespace App\Controllers\Payroll;

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
use App\Models\Vendor_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Izin extends BaseController
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
            'halaman' => 'Izin',
            'daftarkaryawanjp3' => $daftarkaryawanjp3,
            'jnsizin' => $djnsizin,
            'jam_kerja' => $shfjamkerja
        ];

        return view('izin/index', $data);
    }

    public function Validasi()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Validasi Izin'
        ];

        return view('izin/verifikasi', $data);
    }

    public function Ajaxform()
    {
        helper('form');
        if ($this->request->isAJAX()) {
            $idkar = $this->request->getPost('idkar');
            $daftarkaryawanjp3 = $this->pegawaimodel->Daftarkaryawaninsjp3($idkar);
            $msg = [
                'grup' => $daftarkaryawanjp3['grup'],
                'unit' => $daftarkaryawanjp3['unit'],
                'subunit' => $daftarkaryawanjp3['subunit']
            ];
            echo json_encode($msg);
        }
    }

    public function Fio()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $idkar = $this->request->getPost('idkar');
            $tanggal = $this->request->getPost('tanggal');
            $shift = $this->request->getPost('shift');

            if ($idkar != '' && $tanggal != '' && $shift != '') {

                $jamdata = $this->jamkerja->where('jk_id', $shift)->first();
                $pinidkar = $this->pegawaimodel->where('pegawai_nip', $idkar)->first();

                $inmin  = date('Y-m-d H:i:s', strtotime('-2 hours', strtotime($tanggal . ' ' . $jamdata['jk_bcin'])));
                $inmax = date('Y-m-d H:i:s', strtotime('+5 hours', strtotime($tanggal . ' ' . $jamdata['jk_bcin'])));

                $outmin = date('Y-m-d H:i:s', strtotime('+6 hours', strtotime($tanggal . ' ' . $jamdata['jk_bcin'])));
                $outmax = date('Y-m-d H:i:s', strtotime('+17 hours', strtotime($tanggal . ' ' . $jamdata['jk_bcin'])));

                $data = [
                    'idkar' => $pinidkar['pegawai_pin'],
                    'tanggal' => $tanggal,
                    'shift' => $jamdata['jk_bcin'],
                    'inmin' => $inmin,
                    'inmax' => $inmax,
                    'outmin' => $outmin,
                    'outmax' => $outmax,
                ];

                $datain = $this->jamkerja->JampegawaiIn($data);
                $dataout = $this->jamkerja->JampegawaiOut($data);

                if ($datain == '' || $dataout == '') {
                    $msg = [
                        'in' => '',
                        'out' => ''
                    ];
                } else {
                    $msg = [
                        'in' => $datain['scanin'],
                        'out' => $dataout['scanout']
                    ];
                }
            } else {
                $msg = [
                    'in' => '',
                    'out' => ''
                ];
            }

            echo json_encode($msg);
        }
    }

    public function Logizin()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Log Izin'
        ];

        return view('izin/logizin', $data);
    }

    public function Addizin()
    {
        // $image = \Config\Services::image();

        helper('form');

        // $now = new DateTime();
        // $datenow = $now->format('Y-m-d 00:00:00');

        if (in_groups('vendor')) {
            $datenow = date("Y-m-d 00:00:00", strtotime("- 4 day"));
        } else {
            $datenow = date("Y-m-d 00:00:00", strtotime("- 30 day"));
        }

        if ($this->request->isAJAX()) {

            if ($this->request->getMethod() == 'post') {

                $in = $this->request->getPost('in');
                $out = $this->request->getPost('out');

                $timein = Time::parse($in);
                $timeout = Time::parse($out);

                if ($datenow <= date('Y-m-d', strtotime($timein)) || $datenow <= date('Y-m-d', strtotime($timeout))) {


                    $rules = [
                        'idkar' => [
                            'label'  => 'idkar',
                            'rules'  => 'required',
                            'errors' => [
                                'required' => 'idkar harus diisi !',
                            ],
                        ],
                        'nama' => [
                            'label'  => 'nama',
                            'rules'  => 'required',
                            'errors' => [
                                'required' => 'nama harus diisi',
                            ],
                        ],
                        'unit' => [
                            'label'  => 'unit',
                            'rules'  => 'required',
                            'errors' => [
                                'required' => 'unit harus diisi !',
                            ],
                        ],
                        // 'divisi' => [
                        //     'label'  => 'divisi',
                        //     'rules'  => 'required',
                        //     'errors' => [
                        //         'required' => 'Divisi harus diisi !',
                        //     ],
                        // ],
                        'subunit' => [
                            'label'  => 'subunit',
                            'rules'  => 'required',
                            'errors' => [
                                'required' => 'Sub Unit harus diisi !',
                            ],
                        ],
                        'in' => [
                            'label'  => 'in',
                            'rules'  => 'required',
                            'errors' => [
                                'required' => 'in harus diisi !',
                            ],
                        ],
                        'out' => [
                            'label'  => 'out',
                            'rules'  => 'required',
                            'errors' => [
                                'required' => 'out harus diisi !',
                            ],
                        ],
                        // 'izin' => [
                        //     'label'  => 'izin',
                        //     'rules'  => 'required',
                        //     'errors' => [
                        //         'required' => 'izin harus dipilih !',
                        //     ],
                        // ],
                        // 'fileizin' => [
                        //     'label'  => 'fileizin',
                        //     'rules'  => 'uploaded[fileizin]|max_size[fileizin,2048]|mime_in[fileizin,image/png,image/jpeg,image/jpg]|is_image[fileizin]',
                        //     'errors' => [
                        //         'uploaded' => 'File harus diupload !',
                        //         'max_size' => 'File Max 2 MB !',
                        //         'mime_in' => 'Gambar harus berformat PNG, JPG, JPEG',
                        //         'is_image' => 'File yang diinput harus gambar',
                        //     ],
                        // ],
                    ];



                    if ($this->validate($rules)) {
                        $idkar = htmlspecialchars($this->request->getPost('idkar'));
                        $nama = $this->pegawaimodel->Daftarkaryawaninsjp3($idkar);
                        $unit = htmlspecialchars($this->request->getPost('unit'));
                        $subunit = htmlspecialchars($this->request->getPost('subunit'));

                        $grup = htmlspecialchars($this->request->getPost('grup'));
                        $izin = htmlspecialchars($this->request->getPost('izin'));
                        // $fileizin = $this->request->getFile('fileizin');

                        // $filename = $fileizin->getName();
                        // $filerandomname = $fileizin->getRandomName();
                        // $filemimetype = $fileizin->getMimeType();

                        // $image->withFile($fileizin)
                        //     ->resize(200, 100, true, 'height')
                        //     ->save(FCPATH . '/assets/upload/images/izin/' . $filerandomname);

                        if ($izin == '') {
                            $verified = 'a';
                        } else {
                            $verified = 'b';
                        }

                        $data = [
                            'pegawai_nip' => $idkar,
                            'pegawai_nama' => $nama['nama'],
                            'unit' => $unit,
                            'subunit' => $subunit,
                            'in' => $timein->toDateTimeString(),
                            'out' => $timeout->toDateTimeString(),
                            'grup' => $grup,
                            'izin' => $izin,
                            'user_id' => user()->id,
                            // 'file_image' => $filerandomname,
                            'ket' => 'n',
                            'verified' => $verified
                        ];

                        if ($data) {
                            $insert = $this->absensi->insert($data);
                        }

                        if ($insert) {
                            if ($izin == '') {
                                $msg = [
                                    'suksest' => 't'
                                ];
                            } else {
                                $msg = [
                                    'sukses' => view('izin/form', $data)
                                ];
                            }
                            // session()->setFlashdata('success', 'Izin berhasil');
                        }

                        echo json_encode($msg);
                    } else {
                        $msg = [
                            'error' => [
                                'errorid' => $this->validator->getError("idkar"),
                                'errornama' => $this->validator->getError("nama"),
                                // 'errordivisi' => $this->validator->getError("divisi"),
                                'errorunit' => $this->validator->getError("unit"),
                                'errorsubunit' => $this->validator->getError("subunit"),
                                'errorin' => $this->validator->getError("in"),
                                'errorout' => $this->validator->getError("out"),
                                // 'errorizin' => $this->validator->getError("izin")
                            ]
                        ];
                        echo json_encode($msg);
                    }
                } else {
                    $msg = [
                        'error' => [
                            'errorwaktu' => "Input tanggal tersebut ditolak !!! Input Tanggal Keluar dari ketentuan"
                        ]
                    ];
                    echo json_encode($msg);
                }
            }
        }
    }

    public function Delete()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $id = htmlspecialchars($this->request->getPost('idizin'));

            if ($id) {
                $delete = $this->tblizin->delete($id);
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function Ubahbs()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $id = htmlspecialchars($this->request->getPost('idizin'));

            if ($id) {
                $ubahbs = $this->tblizin->where('id_tblizin', $id)->set(['verified' => 'a'])->update();
            }

            if ($ubahbs) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function Ubahbt()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $id = htmlspecialchars($this->request->getPost('idizin'));

            if ($id) {
                $ubahbt = $this->tblizin->where('id_tblizin', $id)->set(['verified' => 'c'])->update();
            }

            if ($ubahbt) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function Datatableslogizin()
    {
        $request = Services::request();
        $logizin = new Tblizin_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $logizin->get_datatableslogizin();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $ls) {
                $no++;
                $row = [];
                $row[] = $ls->nip;
                $row[] = $ls->nama;
                $row[] = 'J M : ' . $ls->fin . ' J K : ' . $ls->fout;
                $row[] = $ls->izin;
                $row[] = $ls->createdat;
                $dataproses = $ls->verified;
                if ($dataproses == 'a') {
                    if ($ls->izin == "") {
                        $row[] = "Diterima <a class=\"btn btn-danger btn-delete btn-sm\" data-deleteizin=\"$ls->idtblizin\">Delete</a>";
                    } else {
                        $row[] = 'Diterima';
                    }
                } elseif ($dataproses == 'b') {
                    $row[] = "Proses Pengajuan <a class=\"btn btn-danger btn-delete btn-sm\" data-deleteizin=\"$ls->idtblizin\">Delete</a>";
                } else {
                    $row[] = 'Ditolak';
                }
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $logizin->count_alllogizin(),
                "recordsFiltered" => $logizin->count_filteredlogizin(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Formizin()
    {
        $request = Services::request();
        $tblizin = new Tblizin_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $tblizin->get_datatablespizin();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $izin) {
                $no++;
                $row = [];
                $row[] = $izin->nip;
                $row[] = $izin->nama;
                $row[] = 'J M : ' . $izin->fin . ' J K : ' . $izin->fout;
                $row[] = $izin->vendor;
                $row[] = $izin->izin;
                $row[] = $izin->createdat;
                $row[] = "<a onclick=\"hapusdata('$izin->createdat')\" class=\"btn btn-danger btn-delete btn-sm\" data-deleteizin=\"$izin->idtblizin\">Delete</a> <a onclick=\"ubahbtdata('$izin->createdat')\" class=\"btn btn-danger btn-ubahbt btn-sm\" data-ubahbtizin=\"$izin->idtblizin\">Tolak</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $tblizin->count_allpizin(),
                "recordsFiltered" => $tblizin->count_filteredpizin(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Formpizin()
    {
        $request = Services::request();
        $tblizin = new Tblizin_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $tblizin->get_datatablesizinb();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $izin) {
                $no++;
                $row = [];
                $row[] = $izin->nip;
                $row[] = $izin->nama;
                $row[] = 'J M : ' . $izin->fin . ' J K : ' . $izin->fout;
                $row[] = $izin->vendor;
                $row[] = $izin->izin;
                $row[] = $izin->createdat;
                $row[] = "<a onclick=\"ubahbsdata('$izin->createdat')\" class=\"btn btn-danger btn-ubahbs btn-sm\" data-ubahbsizin=\"$izin->idtblizin\">Verifikasi</a><a onclick=\"ubahbtdata('$izin->createdat')\" class=\"btn btn-danger btn-ubahbt btn-sm\" data-ubahbtizin=\"$izin->idtblizin\">Tolak</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $tblizin->count_allizinb(),
                "recordsFiltered" => $tblizin->count_filteredpizinb(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
    public function Formtizin()
    {
        $request = Services::request();
        $tblizin = new Tblizin_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $tblizin->get_datatablesizinc();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $izin) {
                $no++;
                $row = [];
                $row[] = $izin->nip;
                $row[] = $izin->nama;
                $row[] = 'J M : ' . $izin->fin . ' J K : ' . $izin->fout;
                $row[] = $izin->vendor;
                $row[] = $izin->izin;
                $row[] = $izin->createdat;
                $row[] = "<a onclick=\"hapusdata('$izin->createdat')\" class=\"btn btn-danger btn-delete btn-sm\" data-deleteizin=\"$izin->idtblizin\">Delete</a><a onclick=\"ubahbsdata('$izin->createdat')\" class=\"btn btn-danger btn-ubahbs btn-sm\" data-ubahbsizin=\"$izin->idtblizin\">Verifikasi</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $tblizin->count_allizinc(),
                "recordsFiltered" => $tblizin->count_filteredizinc(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
