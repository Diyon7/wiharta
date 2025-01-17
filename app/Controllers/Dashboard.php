<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pegawai_Model;
use App\Models\Unit_model;
use App\Models\Vendor_model;
use Config\Services;
use DateTime;

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

        if (has_permission('dashboardsdm')) {

            $jumlahdatapervendor = $this->pegawaimodel->JAvendor();
            $datenow = date("Y-m-d 00:00:00", strtotime("yesterday"));



            $data = [
                'title' => 'WKA INFORMATION SYSTEM',
                'devisi' => 'Dashboard SDM',
                'jumlahpervendor' => $jumlahdatapervendor,
                'halaman' => 'Dashboard',
                'tanggalsekarang' => $datenow
            ];

            return view('dashboard/home', $data);
        } else {
            $data = [
                'title' => 'WKA INFORMATION SYSTEM',
                'devisi' => 'Dashboard SDM',
                'halaman' => 'Dashboard',
            ];

            return view('dashboard/home2', $data);
        }
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
