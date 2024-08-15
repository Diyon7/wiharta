<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\Data\Kemasan_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Kemasan extends BaseController
{

    protected $kemasan;
    protected $useritv;

    public function __construct()
    {
        $this->kemasan = new Kemasan_model();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'Kemasan',
        ];

        return view('exim/data/kemasan/index', $data);
    }

    public function Addkemasan()
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
                    $satuan = $this->request->getPost('satuan');
                    $satuan_besar = $this->request->getPost('satuan_besar');

                    $tambahkemasan = [
                        'kode' => $kode_item,
                        'satuan' => $satuan,
                        'satuan_besar' => $satuan_besar,
                    ];

                    $save = $this->kemasan->insert($tambahkemasan);

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
        $kemasan = new Kemasan_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $kemasan->get_datatableskemasan();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->kode;
                $row[] = $gs->satuan;
                $row[] = $gs->satuan_besar;
                $row[] = "<a class=\"btn btn-primary btn-delete text-xs btn-xs\" data-deleteizin=\"\">Edit</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $kemasan->count_allkemasan(),
                "recordsFiltered" => $kemasan->count_filteredkemasan(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
