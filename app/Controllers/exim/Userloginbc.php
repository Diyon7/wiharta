<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Userloginbc extends BaseController
{

    protected $useritv;

    public function __construct()
    {
        $this->useritv = new Useritv_model();
    }

    public function Index()
    {

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();

        $data = [
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'useritv',
        ];

        return view('exim/useritv', $data);
    }

    public function Adduseritv()
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
                    $useritv = $this->request->getPost('useritv');

                    $tambahuseritv = [
                        'kode' => $kode_item,
                        'useritv' => $useritv,
                    ];

                    $save = $this->useritv->insert($tambahuseritv);

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
        $useritv = new useritv_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $useritv->get_datatablesuseritv();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->user;
                $row[] = $gs->datetime;
                $row[] = $gs->ipaddress;
                $row[] = $gs->sistem_operasi;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $useritv->count_alluseritv(),
                "recordsFiltered" => $useritv->count_filtereduseritv(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
