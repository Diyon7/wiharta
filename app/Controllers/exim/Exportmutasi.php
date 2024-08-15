<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\barangjadi\Saldoawal_model;
use App\Models\exim\barangjadi\Exportmutasi_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Exportmutasi extends BaseController
{

    protected $saldoawal;
    protected $export;
    protected $useritv;

    public function __construct()
    {
        $this->saldoawal = new Saldoawal_model();
        $this->export = new Exportmutasi_model();
        $this->useritv = new Useritv_model();
    }

    public function Index()
    {

        $peb = $this->export->Peb();
        $item = $this->export->Allitem();
        $coba = $this->export->Coba();

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();
        $rendered[] = '<p>Page rendered in {elapsed_time} seconds</p>';

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'peb' => $peb,
            'coba' => array_merge($rendered, $coba),
            'item' => $item,
            'halaman' => 'Export Mutasi',
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/bjadi/exportmutasi/index', $data);
    }

    public function Edit()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $aju = $this->export->Aju();
            // $item = $this->export->Allitem();

            $id = $this->request->getPost('id');


            $editexport = $this->export->Edit($id);

            $data = [
                'aju' => $aju,
                // 'item' => $item,
                'edit' => $editexport

            ];
            $msg = [
                'sukses' => view('exim/bjadi/exportmutasi/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Editi()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $item = $this->export->Allitem();

            $id = $this->request->getPost('id');


            $editexport = $this->export->Editi($id);

            $data = [
                'item' => $item,
                'edit' => $editexport

            ];
            $msg = [
                'sukses' => view('exim/bjadi/exportmutasi/editi', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Save()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $seq = htmlspecialchars($this->request->getPost('seq'));
                // $item = htmlspecialchars($this->request->getPost('item'));
                $peb = htmlspecialchars($this->request->getPost('peb'));
                $tglpeb = htmlspecialchars($this->request->getPost('tglpeb'));
                $inv = htmlspecialchars($this->request->getPost('inv'));
                $tglinv = htmlspecialchars($this->request->getPost('tglinv'));
                $nilai = htmlspecialchars($this->request->getPost('nilai'));
                $kgm = htmlspecialchars($this->request->getPost('kgm'));
                $qty = htmlspecialchars($this->request->getPost('qty'));
                $no_aju = htmlspecialchars($this->request->getPost('no_aju'));


                $dtl = [
                    // 'kode_item' => $item,
                    'peb' => $peb,
                    'tglpeb' => $tglpeb,
                    'inv' => $inv,
                    'tglinv' => $tglinv,
                    'nilai' => $nilai,
                    'kgm' => $kgm,
                    'qty' => $qty,
                    'aju' => $no_aju
                ];

                $dataupdate = $this->export->where('seq', $seq)->set($dtl)->update();

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

                $seq = htmlspecialchars($this->request->getPost('seq'));
                $item = htmlspecialchars($this->request->getPost('item'));


                $dtl = [
                    'kode_item' => $item,
                ];

                $dataupdate = $this->export->where('seq', $seq)->set($dtl)->update();

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

    public function Nambahaju()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $aju = $this->export->Aju();

            $id = $this->request->getPost('id');


            $addaju = $this->export->find($id);

            $data = [
                'aju' => $aju,
                'add' => $addaju,

            ];
            $msg = [
                'sukses' => view('exim/bjadi/exportmutasi/addaju', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Saveaju()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $seq = htmlspecialchars($this->request->getPost('seq'));
                $data = $this->export->find($seq);
                $aju = htmlspecialchars($this->request->getPost('aju'));
                $qty = htmlspecialchars($this->request->getPost('qty'));
                $kgm = htmlspecialchars($this->request->getPost('kgm'));


                $dtl = [
                    'qty' => $qty,
                    'kgm' => $kgm,
                    'peb' => $data['peb'],
                    'tglpeb' => $data['tglpeb'],
                    'inv' => $data['inv'],
                    'tglinv' => $data['tglinv'],
                    'aju' => $aju,
                    'kode_item' => $data['kode_item'],
                    'customer' => $data['customer'],
                    'negara' => $data['negara'],
                    'sj' => $data['sj'],
                    'tglsj' => $data['tglsj'],
                    'nilai' => $data['nilai'],
                    'code' => $data['code'],
                    'user_id' => user()->username,
                ];

                $dataupdate = $this->export->save($dtl);

                if ($dataupdate) {
                    session()->setFlashdata('success', 'nambah data berhasil');
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

    public function Searchitem()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $idata = $this->request->getVar("search");

            $dataitem = $this->saldoawal->Allitem($idata);

            echo json_encode($dataitem);
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

    public function Deleteexport()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $seq = htmlspecialchars($this->request->getPost('seq'));

            if ($seq) {
                $delete = $this->export->delete($seq);
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function ModalCetak()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'item' => 'modal',

            ];
            $msg = [
                'sukses' => view('exim/bjadi/exportmutasi/modalcetak', $data)
            ];

            echo json_encode($msg);
        }
    }

    function Cetak()
    {
        if ($this->request->isAJAX()) {

            $inv = $this->request->getPost('inv');

            $header = $this->export->Headercetak($inv);

            $listitem = $this->export->Itemcetak($inv);

            $listaju = $this->export->Itemajucetak($inv);

            // $ttd = $this->mutasiproduksi->Namattd($kode2);

            $data = [
                'header' => $header,
                'listitem' => $listitem,
                'listaju' => $listaju,
                'inv' => $inv
                // 'ttd' => $ttd
            ];

            $tampiltabel = [
                'sukses' => view('exim/bjadi/exportmutasi/pdf', $data)
            ];
            echo json_encode($tampiltabel);
        }
    }

    public function Datatablesexport()
    {

        $tgldari = $this->request->getPost('tgldari');
        $tglke = $this->request->getPost('tglke');
        $itemfilter = $this->request->getPost('itemfilter');
        $pebfilter = $this->request->getPost('pebfilter');

        $totalqty = 0;
        $totalkgm = 0;

        $datafilter = [
            'tgldari' => $tgldari,
            'tglke' => $tglke,
            'itemfilter' => $itemfilter,
            'pebfilter' => $pebfilter,
        ];

        $request = Services::request();
        $isi = new Exportmutasi_model($request);
        if ($request->getMethod(true) == "POST") {
            $isiex = $isi->get_datatablesexportmutasi($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($isiex as $ie) {
                $no++;
                $row = [];
                $row[] = $ie->peb;
                $row[] = $ie->tglpeb;
                $row[] = $ie->kode_item;
                $row[] = $ie->nama_item;
                $row[] = $ie->item_description;
                $row[] = $ie->qty;
                $row[] = $ie->kgm;
                $row[] = $ie->aju;
                $row[] = $ie->nilai;
                $row[] = $ie->inv;
                $row[] = $ie->tglinv;
                $row[] = $ie->nobpb;
                $row[] = $ie->tgbpb;
                $row[] = $ie->namacus;
                $row[] = $ie->negara;
                $row[] = $ie->user_id;
                $row[] = $ie->updated_at;
                $row[] = "<a class=\"btn-danger btn-delete text-xs btn-xs\" data-seq=\"$ie->seq\"><i class=\"fas fa-trash\"></i></a><a class=\"btn-success btn-edit text-xs btn-xs\" data-seq=\"$ie->seq\"><i class=\"fas fa-edit\"></i></a> <a class=\"btn-primary btn-editi text-xs btn-xs\" data-seq=\"$ie->seq\"><i class=\"fas fa-edit\"></i> Item</a><a class=\"btn-success btn-nambah text-xs btn-xs\" data-seq=\"$ie->seq\"><i class=\"fas fa-plus\"></i></a>";
                $totalkgm = $totalkgm + floatval($ie->kgm);
                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $isi->count_allexportmutasi(),
                "recordsFiltered" => $isi->count_filteredexportmutasi($datafilter),
                "totalkgm" => number_format($totalkgm, 2),
                "rendered" => $rendered,
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
