<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Maintenance extends BaseController
{

    public function Index()
    {

        if (user()->username == 'diyon') {
            
        }
        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Dashboard SDM',
            'halaman' => 'Laporan Harian',
        ];
        return view('errors/html/run', $data);
    }
}