<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\Data\tipeproduksi_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Tipeproduksi extends BaseController
{

    protected $tipeproduksi;
    protected $useritv;

    public function __construct()
    {
        $this->tipeproduksi = new tipeproduksi_model();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'tipeproduksi',
        ];

        return view('exim/data/tipeproduksi/index', $data);
    }

    public function Addtipeproduksi()
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
                    $tipeproduksi = $this->request->getPost('tipeproduksi');

                    $tambahtipeproduksi = [
                        'kode' => $kode_item,
                        'tipeproduksi' => $tipeproduksi,
                    ];

                    $save = $this->tipeproduksi->insert($tambahtipeproduksi);

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
        $tipeproduksi = new tipeproduksi_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $tipeproduksi->get_datatablestipeproduksi();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->kode;
                $row[] = $gs->deskripsi;
                $row[] = "<a class=\"btn btn-primary btn-delete text-xs btn-xs\" data-deleteizin=\"\">Edit</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $tipeproduksi->count_alltipeproduksi(),
                "recordsFiltered" => $tipeproduksi->count_filteredtipeproduksi(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
