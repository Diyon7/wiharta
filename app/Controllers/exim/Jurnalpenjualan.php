<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\barangjadi\Saldoawal_model;
use App\Models\exim\barangjadi\MutasiProduksi_model;
use App\Models\exim\Useritv_model;
use App\Models\exim\jurnal\Jurnalpenjualan_model;
use App\Models\exim\jurnal\Jurnalpenjualandetail_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Jurnalpenjualan extends BaseController
{

    protected $saldoawal;
    protected $mutasiproduksi;
    protected $useritv;
    protected $jurnalpenjualan;
    protected $jurnalpenjualandetail;

    public function __construct()
    {
        $this->saldoawal = new Saldoawal_model();
        $this->mutasiproduksi = new MutasiProduksi_model();
        $this->useritv = new Useritv_model();
        $this->jurnalpenjualan = new Jurnalpenjualan_model();
        $this->jurnalpenjualandetail = new Jurnalpenjualandetail_model();
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
            // 'data' => $this->jurnalpenjualan->Addsaldoawal(),
            'halaman' => 'Jurnal Penjualan',
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/jurnal/jurnalpenjualan/index', $data);
    }

    public function Savejurnalpenjualan()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'bpb' => [
                        'label'  => 'bpb',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'bpb harus di isi !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $bpb = $this->request->getPost('bpb');
                    $tglbpb = $this->request->getPost('tglbpb');
                    $bukti = $this->request->getPost('bukti');
                    $peb = $this->request->getPost('peb');
                    $tglpeb = $this->request->getPost('tglpeb');
                    $inv = $this->request->getPost('inv');
                    $nospp = $this->request->getPost('nospp');
                    $namacus = $this->request->getPost('namacus');
                    $satuan = $this->request->getPost('satuan');
                    $item = $this->request->getPost('item');
                    $qty = $this->request->getPost('qty');
                    $kgm = $this->request->getPost('kgm');
                    $mu = $this->request->getPost('mu');
                    $nilai = $this->request->getPost('nilai');
                    $kurs = $this->request->getPost('kurs');


                    $maxidp = $this->jurnalpenjualan->Idmaxjurnalpenjualan();
                    $inputjurnal = [
                        'id' => $maxidp,
                        'bpb' => $bpb,
                        'tglbpb' => $tglbpb,
                        'peb' => $peb,
                        'tglpeb' => $tglpeb,
                        'inv' => $inv,
                        'cus' => $namacus,
                        'item' => $item,
                        'satuan' => $satuan,
                        'qty' => $qty,
                        'kgm' => $kgm,
                        'nilai' => $nilai,
                        'no_spp' => $nospp,
                        'mu' => $mu,
                        'user_id' => user()->username,
                    ];
                    $insertpb = $this->jurnalpenjualan->insert($inputjurnal);
                    $inputjurnaldetail = [
                        'tgl' => $tglbpb,
                        'bukti' => $bukti,
                        'id' => $maxidp,
                        'bpb' => $bpb,
                        'tglbpb' => $tglbpb,
                        'peb' => $peb,
                        'tglpeb' => $tglpeb,
                        'inv' => $inv,
                        'cus' => $namacus,
                        'item' => $item,
                        'satuan' => $satuan,
                        'qty' => $qty,
                        'kgm' => $kgm,
                        'nilai' =>  $nilai,
                        'debit' => $nilai,
                        'kredit' => $nilai,
                        'kurs' => $kurs,
                        'mu' => $mu,
                    ];
                    $insertpb = $this->jurnalpenjualandetail->insert($inputjurnaldetail);

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
                $insertpb = $this->jurnalpenjualandetail->where('id', $id)->set($edit)->update();

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

    public function Addjurnalpenjualan()
    {
        if ($this->request->isAJAX()) {
            helper('form');
            $seq = $this->request->getPost('id');
            $editjurnalpembelian = $this->jurnalpenjualan->Jurnalpenjualanedit($seq);
            $maxidp = $this->jurnalpenjualan->Idmaxjurnalpenjualan();
            $data = [
                'maxid' => $maxidp,
                'edit' => $editjurnalpembelian,
                'tahun' => date('Y', strtotime($editjurnalpembelian['tgpeb'])),
                'bulan' => date('m', strtotime($editjurnalpembelian['tgpeb'])),
            ];
            $msg = [
                'sukses' => view('exim/jurnal/jurnalpenjualan/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Edit()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');


            $edit = $this->jurnalpenjualan->Edit($id);

            $data = [
                'edit' => $edit,

            ];
            $msg = [
                'sukses' => view('exim/jurnal/jurnalpenjualan/editkurs', $data)
            ];

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
                'sukses' => view('exim/jurnal/jurnalpenjualan/modalcetakperiode', $data)
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

            $datajurnal = $this->jurnalpenjualan->Cetakperiode($tgl);

            $data = [
                'tgl' => $tgl,
                'datajurnal' => $datajurnal,
            ];

            $tampiltabel = [
                'sukses' => view('exim/jurnal/jurnalpenjualan/pdf', $data)
            ];
            echo json_encode($tampiltabel);
        }
    }

    function Cetakkode()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');

            $datajurnal = $this->jurnalpenjualan->Cetakkode($id);

            $data = [
                'datajurnal' => $datajurnal,
            ];

            $tampiltabel = [
                'sukses' => view('exim/jurnal/jurnalpenjualan/pdfkode', $data)
            ];
            echo json_encode($tampiltabel);
        }
    }

    public function Datatablessemuajurnalpenjualan()
    {

        $tgldari = $this->request->getPost('tgldari');
        $tglke = $this->request->getPost('tglke');

        $totalqty = 0;
        $totalkgm = 0;

        $datafilter = [
            'tgldari' => $tgldari,
            'tglke' => $tglke,
        ];

        $request = Services::request();
        $jurnalpenjualan2 = new jurnalpenjualan_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $jurnalpenjualan2->get_datatablessemuajurnalpenjualan($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->nobpb;
                $row[] = $gs->tgbpb;
                $row[] = $gs->nopeb;
                $row[] = $gs->tgpeb;
                $row[] = $gs->inv;
                $row[] = $gs->namacus;
                $row[] = $gs->kodeitem;
                $row[] = $gs->desk;
                $row[] = $gs->satuan;
                $row[] = number_format($gs->qty, 2, ',', '.');
                $row[] = number_format($gs->kgm, 2, ',', '.');
                $row[] = $gs->fob;
                $row[] = $gs->mu;
                $row[] = $gs->kurs;
                $row[] = $gs->updated_at;
                $row[] = "<a class=\"btn-edit btn-primary text-xs btn-xs\" data-sec=\"$gs->id\"><i class=\"fas fa-edit\"></i> Kurs</a> <a class=\" btn-success btn-print text-xs btn-xs\" data-id=\"$gs->id\"><i class=\"fas fa-print\"></i></a>";
                $totalkgm = $totalkgm + floatval($gs->kgm);


                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $jurnalpenjualan2->count_allsemuajurnalpenjualan(),
                "recordsFiltered" => $jurnalpenjualan2->count_filteredsemuajurnalpenjualan($datafilter),
                "totalqty" => number_format($totalqty, 2),
                "totalkgm" => number_format($totalkgm, 2),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Datatablesbelumjurnalpenjualan()
    {

        $tgldari = $this->request->getPost('tgldari');
        $tglke = $this->request->getPost('tglke');

        $totalqty = 0;
        $totalkgm = 0;

        $request = Services::request();
        $jurnalpenjualan2 = new jurnalpenjualan_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $jurnalpenjualan2->get_datatablesbelumjurnalpenjualan();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->nobpb;
                $row[] = $gs->tgbpb;
                $row[] = $gs->nopeb;
                $row[] = $gs->tgpeb;
                $row[] = $gs->inv;
                $row[] = $gs->namacus;
                $row[] = $gs->kodeitem;
                $row[] = $gs->desk;
                $row[] = $gs->satuan;
                $row[] = number_format($gs->qty, 2, ',', '.');
                $row[] = number_format($gs->kgm, 2, ',', '.');
                $row[] = $gs->fob;
                $row[] = $gs->mu;
                $row[] = $gs->updated_at;
                if (is_null($gs->id)) {
                    $row[] = "<a class=\"btn-primary btn-add text-xs btn-xs\" data-id=\"$gs->seq\"><i class=\"fas fa-plus\"></i></a>";
                } else {
                    $row[] = '';
                }
                $totalkgm = $totalkgm + floatval($gs->kgm);


                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $jurnalpenjualan2->count_allbelumjurnalpenjualan(),
                "recordsFiltered" => $jurnalpenjualan2->count_filteredbelumjurnalpenjualan(),
                "totalqty" => number_format($totalqty, 2),
                "totalkgm" => number_format($totalkgm, 2),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
