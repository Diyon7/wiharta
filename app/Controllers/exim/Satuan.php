<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\Data\Satuan_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Satuan extends BaseController
{

    protected $satuan;
    protected $useritv;

    public function __construct()
    {
        $this->satuan = new Satuan_model();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'satuan',
        ];

        return view('exim/data/satuan/index', $data);
    }

    public function Addsatuan()
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

                    $tambahsatuan = [
                        'kode' => $kode_item,
                        'satuan' => $satuan,
                    ];

                    $save = $this->satuan->insert($tambahsatuan);

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
        $satuan = new Satuan_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $satuan->get_datatablessatuan();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->kode;
                $row[] = $gs->satuan;
                $row[] = "<a class=\"btn btn-primary btn-delete text-xs btn-xs\" data-deleteizin=\"\">Edit</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $satuan->count_allsatuan(),
                "recordsFiltered" => $satuan->count_filteredsatuan(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
