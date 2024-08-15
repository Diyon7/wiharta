<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\Data\Itemfg_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Itemfg extends BaseController
{

    protected $itemfg;
    protected $useritv;

    public function __construct()
    {
        $this->itemfg = new Itemfg_model();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'itemfg',
        ];

        return view('exim/data/itemfg/index', $data);
    }

    public function Additemfg()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'kode' => [
                        'label'  => 'kode',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Kode harus Diisi !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {

                    $kode_item = $this->request->getPost('kode');
                    $itemfg = $this->request->getPost('itemfg');

                    $tambahitemfg = [
                        'kode' => $kode_item,
                        'itemfg' => $itemfg,
                    ];

                    $save = $this->itemfg->insert($tambahitemfg);

                    $msg = [
                        'success' => 'berhasil',
                    ];
                } else {
                    $msg = [
                        'error' => $this->validator->listErrors()
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function Datatables()
    {
        $request = Services::request();
        $itemfg = new Itemfg_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $itemfg->get_datatablesitemfg();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->kode;
                $row[] = $gs->idmrp;
                $row[] = $gs->nama;
                $row[] = $gs->m_produk_kode;
                $row[] = $gs->tipe_produksi;
                $row[] = $gs->tipe_customer;
                $row[] = $gs->ukuran;
                $row[] = $gs->size_packaging;
                $row[] = $gs->color;
                $row[] = $gs->m_kemasan_kode;
                $row[] = $gs->default_kemasan;
                $row[] = $gs->default_netto;
                $row[] = $gs->default_brutto;
                $row[] = $gs->hs_code_destination;
                $row[] = $gs->m_satuan_kode;
                $row[] = "<a class=\"btn btn-primary btn-delete text-xs btn-xs\" data-deleteizin=\"\">Edit</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $itemfg->count_allitemfg(),
                "recordsFiltered" => $itemfg->count_filtereditemfg(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
