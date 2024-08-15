<?php

namespace App\Controllers\potong;

use App\Controllers\BaseController;
use App\Models\potong\item\Item_model;
use App\Models\potong\item\Tipe_model;
use App\Models\potong\item\Tipedtl_model;
use App\Models\potong\produksi\Rcnproduksi_model;
use App\Models\potong\Spp_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Rcnproduksi extends BaseController
{

    protected $item;
    protected $tipe;
    protected $tipedtl;
    protected $rcnproduksi;
    protected $spp;

    public function __construct()
    {
        $this->item = new Item_model();
        $this->tipe = new Tipe_model();
        $this->tipedtl = new Tipedtl_model();
        $this->rcnproduksi = new Rcnproduksi_model();
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

        return view('potong/rcnproduksi/index', $data);
    }

    public function Tambahrencana()
    {
        if ($this->request->isAJAX()) {

            $no = '0';
            $nospp = $this->request->getPost('nospp');
            $tgl = $this->request->getPost('tgl');
            $tipe = $this->request->getPost('tipe');
            $order = $this->request->getPost('order');

            $carimaxdata = $this->spp->Codercn();

            $no = $carimaxdata['norcn'];
            $no2 = $no + 1;

            $data = [
                'spp' => $nospp,
                'norcn' => $no2,
                'idtipe' => $tipe,
                'jml' => $order,
                'tgl' => $tgl
            ];

            $carimaxdata = $this->spp->insert($data);

            $tampildata = $this->spp->where('norcn', $no2)->first();

            $datarcn = [
                'tampildata' => $tampildata
            ];

            $tampiltabel = [
                'sukses' => view('potong/rcnproduksi/rencana', $datarcn)
            ];

            echo json_encode($tampiltabel);
        }
    }

    public function Tambahdetailrencana()
    {
        if ($this->request->isAJAX()) {

            $no = '0';
            $norcn = $this->request->getPost('norcn');
            $idtipe = $this->request->getPost('idtipe');
            $ven = $this->request->getPost('ven');
            $grup = $this->request->getPost('grup');
            $tgl = $this->request->getPost('tgl');
            $qty = $this->request->getPost('qty');

            $data = [
                'norcn' => $norcn,
                'idtipe' => $idtipe,
                'vendor' => $ven,
                'grup' => $grup,
                'tgl' => $tgl,
                'qty' => $qty,
                'user' => user()->username,
            ];

            $carimaxdata = $this->rcnproduksi->insert($data);

            $data = [
                'success' => 'data sukses'
            ];

            echo json_encode($data);
        }
    }

    public function Edit()
    {
        if ($this->request->isAJAX()) {

            $seq = $this->request->getPost('seq');
            $rencana = $this->rcnproduksi->where('seq', $seq)->find();



            $data = [
                'vendor' => $rencana['vendor'],
                'grup' => $rencana['grup'],
                'tgl' => $rencana['tgl'],
                'qty' => $rencana['qty'],
            ];

            $msg = [
                'sukses' => view('potong/item/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Saverencana()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $seq = $this->request->getPost('seq');
                $vendor = htmlspecialchars($this->request->getPost('vendor'));
                $grup = htmlspecialchars($this->request->getPost('grup'));
                $tgl = htmlspecialchars($this->request->getPost('tgl'));
                $qty = htmlspecialchars($this->request->getPost('qty'));

                $rencana = [
                    'vendor' => $vendor,
                    'grup' => $grup,
                    'tgl' => $tgl,
                    'qty' => $qty,
                ];

                $dataupdate = $this->rcnproduksi->where('seq', $seq)->set($rencana)->update();

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

    public function Delete()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $seq = htmlspecialchars($this->request->getPost('seq'));

            if ($seq) {
                $delete = $this->rcnproduksi->delete($seq);
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function Carircn()
    {
        if ($this->request->isAJAX()) {

            $no = '0';
            $norcn = $this->request->getPost('norcn');

            $tampildata = $this->spp->where('norcn', $norcn)->first();

            $datarcn = [
                'tampildata' => $tampildata
            ];

            $tampiltabel = [
                'sukses' => view('potong/rcnproduksi/rencana', $datarcn)
            ];

            echo json_encode($tampiltabel);
        }
    }


    public function Datatablesrcn()
    {

        $tipe = $this->request->getPost('tipe');
        $norcn = $this->request->getPost('norcn');

        $datafilter = [
            'norcn' => $norcn,
        ];

        $request = Services::request();
        $mutasiproduksi2 = new Rcnproduksi_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $mutasiproduksi2->get_datatablesdetailrencana($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->spp;
                $row[] = $gs->namatipe;
                $row[] = $gs->tgl;
                $row[] = $gs->qty;
                $row[] = "<a class=\"btn-danger btn-delete text-xs btn-xs\" data-seq=\"$gs->seq\"><i class=\"fas fa-trash\"></i></a> <a class=\"btn btn-edit text-xs btn-xs\" data-seq=\"$gs->seq\"><i class=\"fas fa-edit\"></i></a>";
                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $mutasiproduksi2->count_alldetailrencana($datafilter),
                "recordsFiltered" => $mutasiproduksi2->count_filtereddetailrencana($datafilter),
                "rendered" => $rendered,
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Datatablesrabalance()
    {

        $norcn = $this->request->getPost('norcn');

        $datafilter = [
            'norcn' => $norcn
        ];

        $request = Services::request();
        $rencanaproduksi = new Rcnproduksi_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $rencanaproduksi->get_datatablesdetailkumrencana($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->usespp;
                $row[] = $gs->kebutuhan;
                $row[] = $gs->namaitem;
                $row[] = $gs->balancera;
                $row[] = $gs->ra;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $rencanaproduksi->count_alldetailkumrencana($datafilter),
                "recordsFiltered" => $rencanaproduksi->count_filtereddetailkumrencana($datafilter),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}