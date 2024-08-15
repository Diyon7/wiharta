<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\barangjadi\Saldoawal_model;
use App\Models\exim\barangjadi\MutasiProduksi_model;
use App\Models\exim\barangjadi\Exportmutasi_model;
use App\Models\exim\export\Eximitv_model;
use App\Models\exim\export\Pengeluaran_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Eximitv extends BaseController
{

    protected $saldoawal;
    protected $mutasiproduksi;
    protected $export;
    protected $eximitv;
    protected $pengeluaranitv;
    protected $useritv;

    public function __construct()
    {
        $this->saldoawal = new Saldoawal_model();
        $this->mutasiproduksi = new MutasiProduksi_model();
        $this->export = new Exportmutasi_model();
        $this->eximitv = new Eximitv_model();
        $this->pengeluaranitv = new Pengeluaran_model();
        $this->useritv = new Useritv_model();
    }

    public function Index()
    {

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();
        $addeximitv = $this->pengeluaranitv->Dataexim();

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'coba' => $addeximitv,
            'devisi' => 'Exim',
            'halaman' => 'Exim Itv',
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/export/eximitv/index', $data);
    }

    public function Add()
    {
        if ($this->request->isAJAX()) {


            $item = $this->export->Allitem();
            $id = $this->request->getPost('id');


            $addeximitv = $this->eximitv->Add($id);
            $customer = $this->eximitv->Allcustomer($id);

            $data = [
                'coba' => $this->pengeluaranitv->Dataexim(),
                'add' => $addeximitv,
                'item' => $item,
                'customer' => $customer,
            ];
            $msg = [
                'sukses' => view('exim/export/eximitv/add', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Update()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');


            $addeximitv = $this->pengeluaranitv->Dataexim();
            foreach ($addeximitv as $aei) {
                $savedatapengeluaran = [
                    'nopeb' => $aei['no_dokumen'],
                    'tgpeb' => $aei['tgl_dokumen'],
                    'nobpb' => $aei['sj'],
                    'tgbpb' => $aei['tgsj'],
                    'idcus' => $aei['m_customer_kode'],
                    'namacus' => $aei['nama'],
                    'negara' => $aei['negara'],
                    'kodeitem' => $aei['idmrp'],
                    'kodekonversi' => $aei['kode_konversi'],
                    'namabrg' => $aei['m_produk_kode'],
                    'desk' => $aei['brg'],
                    'satuan' => $aei['m_satuan_kode'],
                    'qty' => $aei['qty'],
                    'kgm' => $aei['n_weight'],
                    'mu' => 'USD',
                    'fob' => $aei['total'],
                    'nospp' => $aei['no_order'],
                    'inv' => $aei['kode'],
                    'tglinv' => $aei['tgl'],
                    'user' => USER()->username,
                ];
                $nodokumen = $aei['no_dokumen'];
                $dataupdate = $this->eximitv->save($savedatapengeluaran);
                if ($nodokumen != "") {
                    $addeximitv = $this->pengeluaranitv->Addpeb($nodokumen);
                }
            }

            $msg = [
                'sukses' => 'data sukses tambah'
            ];
            // if ($dataupdate) {
            // } else {
            //     $msg = [
            //         'error' => 'Data kosong'
            //     ];
            // }

            echo json_encode($msg);
        }
    }

    public function Save()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $seq = htmlspecialchars($this->request->getPost('seq'));
                $peb = htmlspecialchars($this->request->getPost('peb'));
                $tglpeb = htmlspecialchars($this->request->getPost('tglpeb'));
                $sj = htmlspecialchars($this->request->getPost('sj'));
                $tglsj = htmlspecialchars($this->request->getPost('tglsj'));
                $inv = htmlspecialchars($this->request->getPost('inv'));
                $tglinv = htmlspecialchars($this->request->getPost('tglinv'));
                $item = htmlspecialchars($this->request->getPost('item'));
                $aju = htmlspecialchars($this->request->getPost('aju'));
                $nilai = htmlspecialchars($this->request->getPost('nilai'));
                $customer = htmlspecialchars($this->request->getPost('customer'));
                $negara = htmlspecialchars($this->request->getPost('negara'));
                $qty = htmlspecialchars($this->request->getPost('qty'));
                $kgm = htmlspecialchars($this->request->getPost('kgm'));

                $saveexport = [
                    'peb' => $peb,
                    'tglpeb' => $tglpeb,
                    'sj' => $sj,
                    'tglsj' => $tglsj,
                    'inv' => $inv,
                    'tglinv' => $tglinv,
                    'kode_item' => $item,
                    'aju' => $aju,
                    'nilai' => $nilai,
                    'customer' => $customer,
                    'negara' => $negara,
                    'qty' => $qty,
                    'kgm' => $kgm,
                    'user_id' => user()->username,
                ];

                $savepengeluaran = [
                    'kodeitem' => $item,
                ];

                $dataupdate = $this->export->save($saveexport);

                $updatep = $this->eximitv->where('seq', $seq)->set($savepengeluaran)->update();

                if ($dataupdate) {
                    session()->setFlashdata('success', 'Tambah data berhasil');
                    $msg = [
                        'success' => 'data sukses tambah'
                    ];
                } else {
                    $msg = [
                        'error' => 'data error'
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function Delete()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $seq = htmlspecialchars($this->request->getPost('seq'));

            if ($seq) {
                $delete = $this->eximitv->delete($seq);
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function Savem()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $sec = htmlspecialchars($this->request->getPost('sec'));
                $tgl = $this->request->getPost('tgl');
                $loka = $this->request->getPost('lokasal');
                $lokt = $this->request->getPost('loktujuan');

                $kodloka = $this->mutasiproduksi->Kodelok($loka);
                $kodlokt = $this->mutasiproduksi->Kodelok($lokt);

                $tgls = date('d', strtotime($tgl));
                $bln = date('m', strtotime($tgl));
                $thn = date('y', strtotime($tgl));
                $nosurat = $tgls . '/' . $loka . '/' . $lokt . '/' . $bln . '/' . $thn;

                $cekhdr = $this->mutasiproduksi->Ceksurat($nosurat);
                if ($cekhdr == 0) {
                    $tambahmutasihdr = [
                        'kode' => $nosurat,
                        'tgl' => $tgl,
                        'lokasi_asal' => $kodloka['Analyst'],
                        'lokasi_tujuan' => $kodlokt['Analyst'],
                        'analyst_asal' => $loka,
                        'analyst_tujuan' => $lokt,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    $savehdr = $this->mutasiproduksi->Addmutasihdr($tambahmutasihdr);
                }

                $dtl = [
                    'iduser' => user()->username,
                    'kode' => $nosurat,
                ];

                $dataupdate = $this->mutasiproduksi->where('sec', $sec)->set($dtl)->update();

                if ($dataupdate) {
                    session()->setFlashdata('success', 'Edit data berhasil');
                    $msg = [
                        'success' => 'data sukses diedit'
                    ];
                } else {
                    $msg = [
                        'error' => 'data error'
                    ];
                }

                echo json_encode($msg);
            }
        }
    }

    public function Savei()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $sec = htmlspecialchars($this->request->getPost('sec'));
                $item = htmlspecialchars($this->request->getPost('item'));


                $dtl = [
                    'item' => $item,
                    'iduser' => user()->username,
                ];

                $dataupdate = $this->mutasiproduksi->where('sec', $sec)->set($dtl)->update();

                if ($dataupdate) {
                    session()->setFlashdata('success', 'Edit data berhasil');
                    $msg = [
                        'success' => 'data sukses diedit'
                    ];
                } else {
                    $msg = [
                        'error' => 'data error'
                    ];
                }

                echo json_encode($msg);
            }
        }
    }

    public function Saveaju()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $sec = htmlspecialchars($this->request->getPost('sec'));
                $kode = htmlspecialchars($this->request->getPost('kode'));
                $item = htmlspecialchars($this->request->getPost('item'));
                $aju = htmlspecialchars($this->request->getPost('no_aju'));
                $qty = htmlspecialchars($this->request->getPost('qty'));
                $kgm = htmlspecialchars($this->request->getPost('kgm'));


                $dtl = [
                    'kode' => $kode,
                    'item' => $item,
                    'ln' => '0',
                    'no_aju' => $aju,
                    'qty' => $qty,
                    'kg' => $kgm,
                    'iduser' => user()->username,
                    'code' => '2'
                ];

                $dataupdate = $this->mutasiproduksi->save($dtl);

                if ($dataupdate) {
                    session()->setFlashdata('success', 'nambah aju data berhasil');
                    $msg = [
                        'success' => 'data sukses diedit'
                    ];
                } else {
                    $msg = [
                        'error' => 'data error'
                    ];
                }

                echo json_encode($msg);
            }
        }
    }

    public function Addmutasiproduksi()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'tgl' => [
                        'label'  => 'tgl',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Tanggal harus Diisi !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $kode_item = $this->request->getPost('itemdes');
                    $code = $this->request->getPost('code');
                    $qty_awal = $this->request->getPost('qty_awal');
                    $netto_awal = $this->request->getPost('netto_awal');
                    $tgl = $this->request->getPost('tgl');
                    $loka = $this->request->getPost('lokasal');
                    $lokt = $this->request->getPost('loktujuan');
                    $aju = $this->request->getPost('aju');

                    $kodloka = $this->mutasiproduksi->Kodelok($loka);
                    $kodlokt = $this->mutasiproduksi->Kodelok($lokt);

                    $tgls = date('d', strtotime($tgl));
                    $bln = date('m', strtotime($tgl));
                    $thn = date('y', strtotime($tgl));
                    $nosurat = $tgls . '/' . $loka . '/' . $lokt . '/' . $bln . '/' . $thn;


                    $user = user()->username;

                    $tambahmutasidtl = [
                        'kode' => $nosurat,
                        'item' => $kode_item,
                        'qty' => $qty_awal,
                        'kg' => $netto_awal,
                        'no_aju' => $aju,
                        'code' => $code,
                        'iduser' => user()->username,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];

                    $cekhdr = $this->mutasiproduksi->Ceksurat($nosurat);
                    if ($cekhdr == 0) {
                        $tambahmutasihdr = [
                            'kode' => $nosurat,
                            'tgl' => $tgl,
                            'lokasi_asal' => $kodloka['Analyst'],
                            'lokasi_tujuan' => $kodlokt['Analyst'],
                            'analyst_asal' => $loka,
                            'analyst_tujuan' => $lokt,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                        $savehdr = $this->mutasiproduksi->Addmutasihdr($tambahmutasihdr);
                    }


                    $save = $this->mutasiproduksi->Addmutasidtl($tambahmutasidtl);
                    // $msg = [
                    //     'success' => $cekhdr,
                    // ];

                    if ($save) {
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

    public function Searchkodeitem()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $namaitem = $this->request->getPost("namaitem");

            $dataitem = $this->saldoawal->Allitem($namaitem);

            $data = [
                'kodeitem' => $dataitem['item']
            ];

            echo json_encode($data);
        }
    }

    public function Deletemutasiproduksi()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $sec = htmlspecialchars($this->request->getPost('sec'));

            if ($sec) {
                $delete = $this->mutasiproduksi->delete($sec);
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function Datatables()
    {

        $totalqty = 0;
        $totalkgm = 0;

        $request = Services::request();
        $eximitv = new Eximitv_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $eximitv->get_datatableseximitv();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->nopeb;
                $row[] = $gs->tgpeb;
                $row[] = $gs->nobpb;
                $row[] = $gs->tgbpb;
                $row[] = $gs->namacus;
                $row[] = $gs->negara;
                $row[] = $gs->kodeitem;
                $row[] = $gs->desk;
                $row[] = $gs->qty;
                $row[] = $gs->kgm;
                $row[] = $gs->fob;
                $row[] = $gs->inv;
                $row[] = "<a class=\"btn-danger btn-delete text-xs btn-xs\" data-seq=\"$gs->seq\"><i class=\"fas fa-trash\"></i></a> <a class=\"btn-success btn-add text-xs btn-xs\" data-seq=\"$gs->seq\"><i class=\"fas fa-plus\"></i></a>";
                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $eximitv->count_alleximitv(),
                "recordsFiltered" => $eximitv->count_filteredeximitv(),
                "rendered" => $rendered,
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}