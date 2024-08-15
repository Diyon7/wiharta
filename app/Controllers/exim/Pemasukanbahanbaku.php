<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\bahanbaku\Pemasukanbahanbaku_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Pemasukanbahanbaku extends BaseController
{

    protected $bahanbaku;
    protected $useritv;

    public function __construct()
    {
        $this->bahanbaku = new Pemasukanbahanbaku_model();
    }

    public function Index()
    {

        // $aju = $this->saldoawal->Aju();

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            // 'aju' => $aju,
            'halaman' => 'Pemasukan Bahan Baku',
        ];

        return view('exim/bahanbaku/pemasukan/index', $data);
    }

    public function Searchbapb()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $idata = $this->request->getVar("search");

            $databapb = $this->bahanbaku->Allreceiver($idata);

            echo json_encode($databapb);
        }
    }

    public function Searchsupplier()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $idata = $this->request->getVar("search");

            $databapb = $this->bahanbaku->Allsupplier($idata);

            echo json_encode($databapb);
        }
    }

    public function Searchajufrombapb()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $idata = $this->request->getPost("bapb");

            $databapb = $this->bahanbaku->Ajufromreceiver($idata);

            echo json_encode($databapb);
        }
    }

    public function Searchcountryfromsupplier()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $idata = $this->request->getPost("supplier");

            $datasupplier = $this->bahanbaku->Countryfromsupplier($idata);

            echo json_encode($datasupplier);
        }
    }

    public function Editpemasukan()
    {
        if ($this->request->isAJAX()) {

            $editpemasukan = $this->request->getPost('editpemasukan');


            $editkarya = $this->bahanbaku->Editpemasukan($editpemasukan);

            $data = [
                'editkaryawanall' => $editkarya
            ];
            $msg = [
                'sukses' => view('exim/bahanbaku/pemasukan/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    // public function Addsaldoawal()
    // {
    //     if ($this->request->isAJAX()) {
    //         if ($this->request->getMethod() == 'post') {

    //             $rules = [
    //                 'tgl' => [
    //                     'label'  => 'tgl',
    //                     'rules'  => 'required',
    //                     'errors' => [
    //                         'required' => 'Kode Item harus dipilih !',
    //                     ],
    //                 ],
    //             ];

    //             if ($this->validate($rules)) {
    //                 $kode_item = $this->request->getPost('kode_item');
    //                 $qty_awal = $this->request->getPost('qty_awal');
    //                 $netto_awal = $this->request->getPost('netto_awal');
    //                 $tgl = $this->request->getPost('tgl');
    //                 $aju = $this->request->getPost('aju');


    //                 $user = user()->username;

    //                 $tambahsaldoawal = [
    //                     'kode_item' => $kode_item,
    //                     'qty_awal' => $qty_awal,
    //                     'netto_awal' => $netto_awal,
    //                     'tgl' => $tgl,
    //                     'aju' => $aju,
    //                     'iduser' => user()->id,
    //                     'created_at' => date('Y-m-d H:i:s')
    //                 ];

    //                 $save = $this->saldoawal->Addrcustomer($tambahsaldoawal);

    //                 if ($save) {
    //                     $msg = [
    //                         'success' => 'berhasil',
    //                     ];
    //                 } else {
    //                     $msg = [
    //                         'error' => 'data masuk error'
    //                     ];
    //                 }
    //             } else {
    //                 $msg = [
    //                     'error' => $this->validator->listErrors()
    //                 ];
    //             }
    //             echo json_encode($msg);
    //         }
    //     }
    // }

    // public function Searchkodeitem()
    // {
    //     helper('form');
    //     if ($this->request->isAJAX()) {

    //         $namaitem = $this->request->getPost("namaitem");

    //         $dataitem = $this->saldoawal->Allitem($namaitem);

    //         $data = [
    //             'kodeitem' => $dataitem['item']
    //         ];

    //         echo json_encode($data);
    //     }
    // }

    public function Datatablespemasukanbahanbaku()
    {
        $request = Services::request();
        $bahan_baku = new Pemasukanbahanbaku_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $bahan_baku->get_datatablespemasukanbahanbaku();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {

                $no++;
                $row = [];
                $row[] = 'BC 2.0';
                $row[] = $gs->aju;
                $row[] = $gs->no_pib;
                $row[] = $gs->tgl_pib;
                $row[] = '1';
                $row[] = $gs->bpb;
                $row[] = $gs->tgl_bpb;
                $row[] = $gs->kode;
                $row[] = $gs->nama_barang;
                $row[] = $gs->satuan;
                $row[] = $gs->qty;
                $row[] = $gs->kgm;
                $row[] = $gs->mu;
                $row[] = $gs->usd;
                $row[] = $gs->gudang;
                $row[] = $gs->subkon;
                $row[] = $gs->negara;
                $row[] = "<a class=\"btn btn-danger btn-editp btn-sm\" data-editpemasukan=\"$gs->seq\">Edit</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $bahan_baku->count_filteredpemasukanbahanbaku(),
                "recordsFiltered" => $bahan_baku->count_allpemasukanbahanbaku(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
