<?php

namespace App\Controllers\potong;

use App\Controllers\BaseController;
use App\Models\exim\barangjadi\Saldoawal_model;
use App\Models\potong\item\Item_model;
use App\Models\potong\item\Tipe_model;
use App\Models\potong\item\Tipedtl_model;
use App\Models\potong\produksi\Prosesproduksi_model;
use App\Models\potong\produksi\Saldoproduksi_model;
use App\Models\potong\Spp_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Prosesproduksi extends BaseController
{

    protected $item;
    protected $tipe;
    protected $tipedtl;
    protected $prosesproduksi;
    protected $saldoproses;
    protected $spp;

    public function __construct()
    {
        $this->item = new Item_model();
        $this->tipe = new Tipe_model();
        $this->tipedtl = new Tipedtl_model();
        $this->prosesproduksi = new Prosesproduksi_model();
        $this->saldoproses = new Saldoproduksi_model();
        $this->spp = new Spp_model();
    }

    public function Index()
    {

        $semuatipe = $this->tipe->findAll();
        $semuaitem = $this->item->findAll();
        $caridataspp = $this->spp->Searchrcn();

        $data = [
            'allspp' => $caridataspp,
            'tipe' => $semuatipe,
            'item' => $semuaitem,
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Item Potong',
        ];

        return view('potong/prosesproduksi/index', $data);
    }

    public function Tambahdetailrealisasi()
    {
        if ($this->request->isAJAX()) {

            $no = '0';
            $norcn = $this->request->getPost('norcn');
            $item = $this->request->getPost('item');
            $ven = $this->request->getPost('ven');
            $grup = $this->request->getPost('grup');
            $tgl = $this->request->getPost('tgl');
            $jmesin = $this->request->getPost('jmesin');
            $rak = $this->request->getPost('rak');
            $qty = $this->request->getPost('qty');
            $kgm = $this->request->getPost('kgm');

            $data = [
                'norcn' => $norcn,
                'iditem' => $item,
                'jenismesin' => $jmesin,
                'no' => $rak,
                'kgm' => $kgm,
                'vendor' => $ven,
                'grup' => $grup,
                'tgl' => $tgl,
                'qty' => $qty,
                'user' => user()->username,
            ];

            $carimaxdata = $this->prosesproduksi->insert($data);

            $data = [
                'success' => 'data sukses'
            ];

            echo json_encode($data);
        }
    }

    public function Tambahsaldorealisasi()
    {
        if ($this->request->isAJAX()) {

            $no = '0';
            $norcn = $this->request->getPost('norcn');
            $item = $this->request->getPost('item');
            $ven = $this->request->getPost('ven');
            $grup = $this->request->getPost('grup');
            $tgl = $this->request->getPost('tgl');
            $jmesin = $this->request->getPost('jmesin');
            $qty = $this->request->getPost('qty');

            $data = [
                'norcn' => $norcn,
                'kodeitem' => $item,
                'jenismesin' => $jmesin,
                'vendor' => $ven,
                'grup' => $grup,
                'tgl' => $tgl,
                'sa_ri' => $qty,
                'user' => user()->username,
            ];

            $carimaxdata = $this->saldoproses->insert($data);

            $data = [
                'success' => $carimaxdata
            ];

            echo json_encode($data);
        }
    }

    public function Delete()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $seq = htmlspecialchars($this->request->getPost('seq'));

            if ($seq) {
                $delete = $this->prosesproduksi->delete($seq);
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function Edit()
    {
        if ($this->request->isAJAX()) {

            $seq = $this->request->getPost('seq');
            $editdata = $this->prosesproduksi->Finddata($seq);
            $editdatarcn = $this->prosesproduksi->where('seq', $seq)->first();
            $caridataspp = $this->prosesproduksi->Searchtipercn($editdatarcn['norcn']);
            $semuatipe = $this->tipe->findAll();
            $semuaitem = $this->item->findAll();



            $data = [
                'item' => $caridataspp,
                'editdata' => $editdata,
                'tipe' => $semuatipe,

            ];
            $msg = [
                'sukses' => view('potong/prosesproduksi/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Saverealisasi()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $seq = $this->request->getPost('seq');
                $vendor = htmlspecialchars($this->request->getPost('vendor'));
                $grup = htmlspecialchars($this->request->getPost('grup'));
                $tgl = htmlspecialchars($this->request->getPost('tgl'));
                $item = htmlspecialchars($this->request->getPost('item'));
                $jmesin = htmlspecialchars($this->request->getPost('jmesin'));
                $qty = htmlspecialchars($this->request->getPost('qty'));
                $kgm = htmlspecialchars($this->request->getPost('kgm'));
                $rak = htmlspecialchars($this->request->getPost('rak'));

                $realisasi = [
                    'vendor' => $vendor,
                    'grup' => $grup,
                    'tgl' => $tgl,
                    'iditem' => $item,
                    'jenismesin' => $jmesin,
                    'qty' => $qty,
                    'kgm' => $kgm,
                    'no' => $rak,
                    'user_update' => user()->username
                ];

                $dataupdate = $this->prosesproduksi->where('seq', $seq)->set($realisasi)->update();

                $msg = [
                    'success' => $dataupdate,
                ];
                // if ($dataupdate) {
                //     session()->setFlashdata('success', 'Edit data berhasil');
                // } else {
                //     $msg = [
                //         'error' => 'data error'
                //     ];
                // }

                echo json_encode($msg);
            }
        }
    }

    public function Carirls()
    {
        if ($this->request->isAJAX()) {

            $no = '0';
            $norcn = $this->request->getPost('norcn');

            $tampildata = $this->spp->where('norcn', $norcn)->first();

            $tampildtipedata = $this->tipedtl->where('kodetipe', $tampildata['idtipe'])->find();
            $namadtipedata = $this->tipedtl->where('kodetipe', $tampildata['idtipe'])->first();

            $datarcn = [
                'tampildata' => $tampildata,
                'tampildtipedata' => $tampildtipedata,
                'namadtipedata' => $namadtipedata
            ];

            $tampiltabel = [
                'sukses' => view('potong/prosesproduksi/realisasi', $datarcn)
            ];

            echo json_encode($tampiltabel);
        }
    }


    public function Datatablesri()
    {

        $norcn = $this->request->getPost('norcn');
        $cariitem = $this->request->getPost('cariitem');
        $carivendor = $this->request->getPost('carivendor');
        $carigrup = $this->request->getPost('carigrup');
        $tgldarir = $this->request->getPost('tgldarir');
        $tglker = $this->request->getPost('tglker');

        $totalqty = 0;
        $totalkgm = 0;

        $datafilter = [
            'norcn' => $norcn,
            'cariitem' => $cariitem,
            'carivendor' => $carivendor,
            'carigrup' => $carigrup,
            'tgldarir' => $tgldarir,
            'tglker' => $tglker,
        ];

        $request = Services::request();
        $prosesproduksi = new Prosesproduksi_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $prosesproduksi->get_datatablesdetailrealisasi($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->namaitem;
                $row[] = $gs->usespp;
                $row[] = $gs->tgl;
                $row[] = $gs->qty;
                $row[] = $gs->kgm;
                $row[] = $gs->grup;
                $row[] = $gs->vendor;
                $row[] = $gs->jenismesin;
                $row[] = "<a class=\"btn-danger btn-delete text-xs btn-xs\" data-seq=\"$gs->seq\"><i class=\"fas fa-trash\"></i></a> <a class=\"btn btn-edit text-xs btn-xs\" data-seq=\"$gs->seq\"><i class=\"fas fa-edit\"></i></a>";
                $totalqty = $totalqty + floatval($gs->qty);
                $totalkgm = $totalkgm + floatval($gs->kgm);
                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $prosesproduksi->count_alldetailrealisasi($datafilter),
                "recordsFiltered" => $prosesproduksi->count_filtereddetailrealisasi($datafilter),
                "totalqty" => $totalqty,
                "totalkgm" => $totalkgm,
                "rendered" => $rendered,
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Datatablesribalance()
    {

        $norcn = $this->request->getPost('norcn');
        $tgldari = $this->request->getPost('tgldari');
        $tglke = $this->request->getPost('tglke');

        $totalqty = 0;
        $totalkgm = 0;

        $datafilter = [
            'norcn' => $norcn,
            'tgldari' => $tgldari,
            'tglke' => $tglke,
        ];

        $request = Services::request();
        $prosesproduksi = new Prosesproduksi_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $prosesproduksi->get_datatablesdetailkumrealisasi($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->namaitem;
                $row[] = $gs->usespp;
                $row[] = $gs->kebutuhan;
                $row[] = $gs->balancera;
                $row[] = $gs->ra;
                $row[] = $gs->qty;
                $row[] = "";
                $row[] = $gs->balanceqty;
                $row[] = "";
                $row[] = $gs->qtyrjm;
                $row[] = $gs->qtyprjm;
                $row[] = $gs->qtyhmn;
                $row[] = $gs->qtyphmn;
                $row[] = $gs->qtyska;
                $row[] = $gs->qtypska;
                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $prosesproduksi->count_alldetailkumrealisasi($datafilter),
                "recordsFiltered" => $prosesproduksi->count_filtereddetailkumrealisasi($datafilter),
                "totalqty" => $totalqty,
                "totalkgm" => $totalkgm,
                "rendered" => $rendered,
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}