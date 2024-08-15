<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\Data\Delterm_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Delterm extends BaseController
{

    protected $delterm;
    protected $useritv;

    public function __construct()
    {
        $this->delterm = new Delterm_model();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'Del Term',
        ];

        return view('exim/data/delterm/index', $data);
    }

    public function Adddelterm()
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
                    $delterm = $this->request->getPost('delterm');

                    $tambahdelterm = [
                        'kode' => $kode_item,
                        'delterm' => $delterm,
                    ];

                    $save = $this->delterm->insert($tambahdelterm);

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
        $delterm = new Delterm_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $delterm->get_datatablesdelterm();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->kode;
                $row[] = $gs->del_tem;
                $row[] = "<a class=\"btn btn-primary btn-delete text-xs btn-xs\" data-deleteizin=\"\">Edit</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $delterm->count_alldelterm(),
                "recordsFiltered" => $delterm->count_filtereddelterm(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
