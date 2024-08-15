<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\barangjadi\Saldoawal_model;
use App\Models\exim\export\Bclkt_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Bclkt extends BaseController
{

    protected $saldoawal;
    protected $bclkt;
    protected $useritv;

    public function __construct()
    {
        $this->saldoawal = new Saldoawal_model();
        $this->bclkt = new Bclkt_model();
        $this->useritv = new Useritv_model();
    }

    public function Index()
    {

        $blbclkt = $this->bclkt->Caribelumlaporbclkt();

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();
        $rendered[] = '<p>Page rendered in {elapsed_time} seconds</p>';

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'blbclkt' => $blbclkt,
            'halaman' => 'BCLKT KITE',
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/export/bclkt/index', $data);
    }

    public function Laporkanbclkt()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $peb = $this->request->getPost('peb');

            $bclk = [
                'bclkt' => 's'
            ];

            $datalaporkan = $this->bclkt->where('peb', $peb)->set($bclk)->update();

            if ($datalaporkan) {
                $msg = [
                    'success' => 'data sukses diedit'
                ];
            } else {
                $msg = [
                    'error' => 'data error'
                ];
            }
            echo json_encode($msg);
        }
    }


    public function Nambah()
    {
        if ($this->request->isAJAX()) {
            helper('form');
            $blbclkt = $this->bclkt->Caribelumlaporbclkt();
            $data = [
                'blbclkt' => $blbclkt,
            ];
            $msg = [
                'sukses' => view('exim/export/bclkt/tambah', $data)
            ];

            echo json_encode($msg);
        }
    }


    public function Cancel()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {
                helper('form');

                $peb = $this->request->getPost('peb');

                $bclk = [
                    'bclkt' => 'b'
                ];

                $datalaporkan = $this->bclkt->where('peb', $peb)->set($bclk)->update();

                if ($datalaporkan) {
                    session()->setFlashdata('success', 'Edit data berhasil');
                    $msg = [
                        'success' => 'data sukses diedit'
                    ];
                } else {
                    $msg = [
                        'error' => 'data error'
                    ];
                }


                echo json_encode($msg);
            }
        }
    }

    public function Datatablesbclkt()
    {

        $totalqty = 0;
        $totalkgm = 0;

        $request = Services::request();
        $isi = new Bclkt_model($request);
        if ($request->getMethod(true) == "POST") {
            $isiex = $isi->get_datatablesbclkt();
            $data = [];
            $no = $request->getPost("start");
            foreach ($isiex as $ie) {
                $no++;
                $row = [];
                $row[] = $ie->peb;
                $row[] = $ie->tglpeb;
                $row[] = $ie->jbclkt;
                $row[] = $ie->updated_at;
                $row[] = "<a class=\"btn-danger btn-peb text-xs btn-xs\" data-peb=\"$ie->peb\"><i class=\"fas fa-trash\"></i> Batal</a> <a class=\"btn-danger btn-edit text-xs btn-xs\" data-peb=\"$ie->peb\"><i class=\"fas fa-edit\"></i> Update</a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $isi->count_allbclkt(),
                "recordsFiltered" => $isi->count_filteredbclkt(),
                "totalkgm" => number_format($totalkgm, 2),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
