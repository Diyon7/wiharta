<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\barangjadi\Saldoawal_model;
use App\Models\exim\barangjadi\MutasiProduksi_model;
use App\Models\exim\Useritv_model;
use App\Models\exim\jurnal\Jurnalpembelian_model;
use App\Models\exim\jurnal\Jurnalpembeliandetail_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Jurnalpembelian extends BaseController
{

    protected $saldoawal;
    protected $mutasiproduksi;
    protected $useritv;
    protected $jurnalpembelian;
    protected $detailjurnalpembelian;

    public function __construct()
    {
        $this->saldoawal = new Saldoawal_model();
        $this->mutasiproduksi = new MutasiProduksi_model();
        $this->useritv = new Useritv_model();
        $this->jurnalpembelian = new Jurnalpembelian_model();
        $this->detailjurnalpembelian = new Jurnalpembeliandetail_model();
    }

    public function Index()
    {

        $lok = $this->saldoawal->Lokasi();
        $aju = $this->saldoawal->Aju();
        $item = $this->mutasiproduksi->Allitem();
        $analyst = $this->mutasiproduksi->Allanalyst();

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            // 'data' => $this->jurnalpembelian->Addsaldoawal(),
            'halaman' => 'Jurnal Pembelian',
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/jurnal/jurnalpembelian/index', $data);
    }

    public function Saveedit()
    {
        if ($this->request->isAJAX()) {

            $rules = [
                'kurs' => [
                    'label'  => 'kurs',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'kurs harus di isi !',
                    ],
                ],
            ];

            if ($this->validate($rules)) {
                $id = $this->request->getPost('id');
                $kurs = $this->request->getPost('kurs');
                $edit = [
                    'kurs' => $kurs
                ];
                $insertpb = $this->detailjurnalpembelian->where('id', $id)->set($edit)->update();

                if ($insertpb) {
                    $msg = [
                        'success' => 'berhasil',
                    ];
                } else {
                    $msg = [
                        'error' => 'data masuk error'
                    ];
                }
            } else {
                $msg = [
                    'error' => $this->validator->listErrors()
                ];
            }
            echo json_encode($msg);
        }
    }

    public function Addjurnalpembelian()
    {
        if ($this->request->isAJAX()) {
            helper('form');
            $seq = $this->request->getPost('id');
            $editjurnalpembelian = $this->jurnalpembelian->Jurnalpembelianedit($seq);
            $kurs = $this->jurnalpembelian->Kurs();
            $maxidp = $this->jurnalpembelian->Idmaxjurnalpembelian();
            $data = [
                'maxid' => $maxidp,
                'edit' => $editjurnalpembelian,
                'kurs' => $kurs,
                'tahun' => date('Y', strtotime($editjurnalpembelian['tgl_bapb'])),
                'bulan' => date('m', strtotime($editjurnalpembelian['tgl_bapb'])),
            ];
            $msg = [
                'sukses' => view('exim/jurnal/jurnalpembelian/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Edit()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');


            $edit = $this->jurnalpembelian->Edit($id);

            $data = [
                'edit' => $edit,

            ];
            $msg = [
                'sukses' => view('exim/jurnal/jurnalpembelian/editkurs', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Delete()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $id = htmlspecialchars($this->request->getPost('id'));

            if ($id) {
                $delete = $this->jurnalpembelian->where("id", $id)->delete();
                $deletedetail = $this->detailjurnalpembelian->where("id", $id)->delete();
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function Savejurnalpembelian()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'bapb' => [
                        'label'  => 'bapb',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'bapb harus di isi !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $bapb = $this->request->getPost('bapb');
                    $tglbapb = $this->request->getPost('tglbapb');
                    $bukti = $this->request->getPost('bukti');
                    $aju = $this->request->getPost('aju');
                    $item = $this->request->getPost('item');
                    $po = $this->request->getPost('po');
                    $supplyer = $this->request->getPost('supplyer');
                    $fasilitas = $this->request->getPost('fasilitas');
                    $qty = $this->request->getPost('qty');
                    $kgm = $this->request->getPost('kgm');
                    $stn = $this->request->getPost('stn');
                    $nilai = $this->request->getPost('nilai');
                    $mu = $this->request->getPost('mu');
                    $kurs = $this->request->getPost('kurs');

                    $maxidp = $this->jurnalpembelian->Idmaxjurnalpembelian();

                    $inputjurnal = [
                        'id' => $maxidp,
                        'bapb' => $bapb,
                        'tglbapb' => $tglbapb,
                        'aju' => $aju,
                        'po' => $po,
                        'vendor' => $supplyer,
                        'fasilitas' => $fasilitas,
                        'item' => $item,
                        'satuan' => $stn,
                        'qty' => $qty,
                        'kgm' => $kgm,
                        'nilai' => $nilai,
                        'user' => user()->username,
                    ];

                    $insertpb = $this->jurnalpembelian->insert($inputjurnal);

                    $inputjurnaldetail = [
                        'tgl' => $tglbapb,
                        'bukti' => $bukti,
                        'id' => $maxidp,
                        'bapb' => $bapb,
                        'tglbapb' => $tglbapb,
                        'aju' => $aju,
                        'po' => $po,
                        'vendor' => $supplyer,
                        'fasilitas' => $fasilitas,
                        'item' => $item,
                        'satuan' => $stn,
                        'qty' => $qty,
                        'kgm' => $kgm,
                        'debit' => $nilai,
                        'kredit' => $nilai,
                        'kurs' => $kurs,
                        'mu' => $mu,
                    ];

                    $insertpb2 = $this->detailjurnalpembelian->insert($inputjurnaldetail);

                    if ($insertpb) {
                        $msg = [
                            'success' => 'berhasil',
                        ];
                    } else {
                        $msg = [
                            'error' => 'data masuk error'
                        ];
                    }
                } else {
                    $msg = [
                        'error' => $this->validator->listErrors()
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function ModalCetakperiode()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'item' => 'modal',

            ];
            $msg = [
                'sukses' => view('exim/jurnal/jurnalpembelian/modalcetakperiode', $data)
            ];

            echo json_encode($msg);
        }
    }

    function Cetakperiode()
    {
        if ($this->request->isAJAX()) {

            $tgldari = $this->request->getPost('tgldari');
            $tglke = $this->request->getPost('tglke');

            $tgl = [
                'tgldari' => $tgldari,
                'tglke' => $tglke
            ];

            $datajurnal = $this->jurnalpembelian->Cetakperiode($tgl);

            $data = [
                'tgl' => $tgl,
                'datajurnal' => $datajurnal,
            ];

            $tampiltabel = [
                'sukses' => view('exim/jurnal/jurnalpembelian/pdf', $data)
            ];
            echo json_encode($tampiltabel);
        }
    }

    function Cetakkode()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');

            $datajurnal = $this->jurnalpembelian->Cetakkode($id);

            $data = [
                'datajurnal' => $datajurnal,
            ];

            $tampiltabel = [
                'sukses' => view('exim/jurnal/jurnalpembelian/pdfkode', $data)
            ];
            echo json_encode($tampiltabel);
        }
    }

    public function Datatablesbjurnalpembelian()
    {

        $tgldari = $this->request->getPost('tgldari');
        $tglke = $this->request->getPost('tglke');

        $datafilter = [
            'tgldari' => $tgldari,
            'tglke' => $tglke,
        ];

        $request = Services::request();
        $jurnalpembelian2 = new Jurnalpembelian_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $jurnalpembelian2->get_datatablesbjurnalpembelian($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->bapb;
                $row[] = $gs->tgl_bapb;
                $row[] = $gs->aju;
                $row[] = $gs->po;
                $row[] = $gs->supplyer;
                $row[] = $gs->rec_item;
                $row[] = $gs->item_description;
                $row[] = $gs->stn;
                $row[] = number_format($gs->qt, 2, ',', '.');
                $row[] = number_format($gs->kg, 2, ',', '.');
                $row[] = number_format($gs->nilai, 2, ',', '.');
                $row[] = "<a class=\"btn-success btn-add text-xs btn-xs\" data-seq=\"$gs->seq\"><i class=\"fas fa-plus\"></i></a>";
                // $totalkgm = $totalkgm + floatval($gs->kg);


                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $jurnalpembelian2->count_allbjurnalpembelian(),
                "rendered" => $rendered,
                "recordsFiltered" => $jurnalpembelian2->count_filteredbjurnalpembelian($datafilter),
                // "totalqty" => number_format($totalqty, 2),
                // "totalkgm" => number_format($totalkgm, 2),
                "data" => $data,
                "datafilter" => $datafilter
            ];
            echo json_encode($output);
        }
    }

    public function Datatablessejurnalpembelian()
    {

        $tgldari = $this->request->getPost('tgldari');
        $tglke = $this->request->getPost('tglke');

        // $totalqty = 0;
        // $totalkgm = 0;

        $datafilter = [
            'tgldari' => $tgldari,
            'tglke' => $tglke,
        ];

        $request = Services::request();
        $jurnalpembelian2 = new Jurnalpembelian_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $jurnalpembelian2->get_datatablessejurnalpembelian($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->bapb;
                $row[] = $gs->tgl_bapb;
                $row[] = $gs->aju;
                $row[] = $gs->po;
                $row[] = $gs->supplyer;
                $row[] = $gs->rec_item;
                $row[] = $gs->item_description;
                $row[] = $gs->stn;
                $row[] = number_format($gs->qt, 2, ',', '.');
                $row[] = number_format($gs->kg, 2, ',', '.');
                $row[] = number_format($gs->nilai, 2, ',', '.');
                $row[] = number_format($gs->kurs, 2, ',', '.');
                if ($gs->id == "") {
                    $deletebutton = "";
                } else {
                    $deletebutton = "<a class=\" btn-danger btn-delete text-xs btn-xs\" data-id=\"$gs->id\"><i class=\"fas fa-trash\"></i></a>";
                }
                $row[] = "<a class=\" btn-primary btn-print text-xs btn-xs\" data-id=\"$gs->id\"><i class=\"fas fa-print\"></i></a> <a class=\" btn-success btn-edit text-xs btn-xs\" data-id=\"$gs->id\"><i class=\"fas fa-edit\"></i></a> " . $deletebutton;
                // $totalkgm = $totalkgm + floatval($gs->kg);


                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $jurnalpembelian2->count_allsejurnalpembelian(),
                "rendered" => $rendered,
                "recordsFiltered" => $jurnalpembelian2->count_filteredsejurnalpembelian($datafilter),
                // "totalqty" => number_format($totalqty, 2),
                // "totalkgm" => number_format($totalkgm, 2),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}