<?php

namespace App\Controllers\Payroll;

use App\Controllers\BaseController;
use App\Models\Pegawai_Model;
use App\Models\Unit_model;
use App\Models\Vendor_model;
use Config\Services;

class Dashboard extends BaseController
{

    protected $pegawaimodel;
    protected $unitmodel;
    protected $vendormodel;

    public function __construct()
    {
        $this->pegawaimodel = new Pegawai_Model();
        $this->unitmodel = new Unit_model();
        $this->vendormodel = new Vendor_model();
    }

    public function Index()
    {

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Dashboard SDM',
            'halaman' => 'Dashboard SDM',
        ];

        return view('login', $data);
    }

    public function Detail()
    {
        if ($this->request->isAJAX()) {
            $datav = $this->request->getPost('namavendor');

            $namadvendor = $this->vendormodel->where('pembagian3_nama', $datav)->first();

            $datavendor = $this->pegawaimodel->Datapv($datav);
            $data = [
                'ndv' => $namadvendor['pembagian3_nama'],
                'dvendor' => $datavendor
            ];
            $msg = [
                'sukses' => view('dashboard/detail', $data)
            ];

            echo json_encode($msg);
        }
    }
}
