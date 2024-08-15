<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\Data\Agent_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Agent extends BaseController
{

    protected $agent;
    protected $useritv;

    public function __construct()
    {
        $this->agent = new Agent_model();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'agent',
        ];

        return view('exim/data/agen/index', $data);
    }

    public function Addagent()
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
                    $agent = $this->request->getPost('agent');

                    $tambahagent = [
                        'kode' => $kode_item,
                        'agent' => $agent,
                    ];

                    $save = $this->agent->insert($tambahagent);

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
        $agent = new Agent_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $agent->get_datatablesagen();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->kode;
                $row[] = $gs->nama;
                $row[] = $gs->nama_pendek;
                $row[] = $gs->alamat;
                $row[] = $gs->kota;
                $row[] = $gs->tlp;
                $row[] = $gs->fax;
                $row[] = $gs->attn;
                $row[] = $gs->tipe;
                $row[] = "<a class=\"btn btn-primary btn-delete text-xs btn-xs\" data-deleteizin=\"\">Edit</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $agent->count_allagen(),
                "recordsFiltered" => $agent->count_filteredagen(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
