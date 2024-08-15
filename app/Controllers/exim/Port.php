<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\Data\Port_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class port extends BaseController
{

    protected $port;
    protected $useritv;

    public function __construct()
    {
        $this->port = new Port_model();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'port',
        ];

        return view('exim/data/port/index', $data);
    }

    public function Addport()
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
                    $port = $this->request->getPost('port');

                    $tambahport = [
                        'kode' => $kode_item,
                        'port' => $port,
                    ];

                    $save = $this->port->insert($tambahport);

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
        $port = new Port_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $port->get_datatablesport();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->kode;
                $row[] = $gs->port;
                $row[] = $gs->nama_pendek;
                $row[] = $gs->kode_port;
                $row[] = $gs->negara;
                $row[] = "<a class=\"btn btn-primary btn-delete text-xs btn-xs\" data-deleteizin=\"\">Edit</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $port->count_allport(),
                "recordsFiltered" => $port->count_filteredport(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
