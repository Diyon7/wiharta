<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\Data\Produk_model;
use Config\Services;
use App\Models\exim\Useritv_model;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Produk extends BaseController
{

    protected $produk;
    protected $useritv;

    public function __construct()
    {
        $this->produk = new Produk_model();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'produk',
        ];

        return view('exim/data/produk/index', $data);
    }

    public function Addproduk()
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
                    $produk = $this->request->getPost('produk');
                    $m_satuan_kode = $this->request->getPost('m_satuan_kode');
                    $hs_code = $this->request->getPost('hs_code');

                    $tambahproduk = [
                        'kode' => $kode_item,
                        'produk' => $produk,
                        'm_satuan_kode' => $m_satuan_kode,
                        'hs_code' => $hs_code
                    ];

                    $save = $this->produk->insert($tambahproduk);

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
        $produk = new Produk_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $produk->get_datatablesproduk();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->kode;
                $row[] = $gs->produk;
                $row[] = $gs->m_satuan_kode;
                $row[] = $gs->hs_code;
                $row[] = "<a class=\"btn btn-primary btn-delete text-xs btn-xs\" data-deleteizin=\"\">Edit</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $produk->count_allproduk(),
                "recordsFiltered" => $produk->count_filteredproduk(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
