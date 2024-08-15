<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\Data\Negara_model;
use Config\Services;
use App\Models\exim\Useritv_model;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Negara extends BaseController
{

    protected $negara;
    protected $useritv;

    public function __construct()
    {
        $this->negara = new Negara_model();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'Negara',
        ];

        return view('exim/data/negara/index', $data);
    }

    public function Addnegara()
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
                    $negara = $this->request->getPost('negara');

                    $tambahnegara = [
                        'kode' => $kode_item,
                        'negara' => $negara,
                    ];

                    $save = $this->negara->insert($tambahnegara);

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
        $negara = new Negara_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $negara->get_datatablesnegara();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->kode;
                $row[] = $gs->negara;
                $row[] = "<a class=\"btn btn-primary btn-delete text-xs btn-xs\" data-deleteizin=\"\">Edit</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $negara->count_allnegara(),
                "recordsFiltered" => $negara->count_filterednegara(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
