<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\barangjadi\Saldoawal_model;
use App\Models\exim\barangjadi\MutasiProduksi_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Penyerahan extends BaseController
{

    protected $saldoawal;
    protected $mutasiproduksi;
    protected $useritv;

    public function __construct()
    {
        $this->saldoawal = new Saldoawal_model();
        $this->mutasiproduksi = new MutasiProduksi_model();
        $this->useritv = new Useritv_model();
    }

    public function Index()
    {

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Penyerahan',
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/bjadi/penyerahan/index', $data);
    }

    public function Searchitem()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $idata = $this->request->getVar("search");

            $dataitem = $this->mutasiproduksi->Allitemserver($idata);

            echo json_encode($dataitem);
        }
    }

    public function Datatablesmutasiproduksi()
    {

        $pilihtujuan = $this->request->getPost('pilihtujuan');
        $tgldari = $this->request->getPost('tgldari');
        $tglke = $this->request->getPost('tglke');
        $itemfilter = $this->request->getPost('itemfilter');

        $totalqty = 0;
        $totalkgm = 0;

        $datafilter = [
            'pilihtujuan' => $pilihtujuan,
            'tgldari' => $tgldari,
            'tglke' => $tglke,
            'itemfilter' => $itemfilter,
        ];

        $request = Services::request();
        $mutasiproduksi2 = new MutasiProduksi_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $mutasiproduksi2->get_datatablesmutasiproduksi($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $gs->kode;
                $row[] = $gs->tgl;
                $row[] = $gs->no_aju;
                $row[] = $gs->item;
                $row[] = $gs->asal;
                $row[] = $gs->nama_item;
                $row[] = $gs->item_description;
                $row[] = $gs->alltotalqty;
                $row[] = $gs->kgm;
                $row[] = $gs->user;
                $row[] = $gs->updated_at;
                if ($gs->code == '1') {
                    $btn = "btn-warning";
                } else {
                    $btn = "btn-success";
                }
                if ($gs->asal == 'Hasil Produksi Unit Finishing') {
                    if ($gs->code == '1') {
                        $totalqty = $totalqty + floatval($gs->alltotalqty);
                    }
                    $row[] = "<a class=\"btn-danger btn-delete text-xs btn-xs\" data-sec=\"$gs->sec\"><i class=\"fas fa-trash\"></i></a> <a class=\" $btn btn-edit text-xs btn-xs\" data-sec=\"$gs->sec\"><i class=\"fas fa-edit\"></i></a> <a class=\" btn-success btn-editi text-xs btn-xs\" data-sec=\"$gs->sec\"><i class=\"fas fa-edit\"></i> Item</a> <a class=\"btn-editm btn-primary text-xs btn-xs\" data-sec=\"$gs->sec\"><i class=\"fas fa-edit\"></i> Kode</a> <a class=\"btn-success btn-add text-xs btn-xs\" data-sec=\"$gs->sec\"><i class=\"fas fa-plus\"></i></a>";
                } else {
                    $totalqty = $totalqty + floatval($gs->alltotalqty);
                    $row[] = "<a class=\"btn btn-danger btn-delete text-xs btn-xs\" data-sec=\"$gs->sec\">Hapus</a> <a class=\"btn-editm btn-primary text-xs btn-xs\" data-sec=\"$gs->sec\"><i class=\"fas fa-edit\"></i> M</a> <a class=\"btn btn-success btn-edit text-xs btn-xs\" data-sec=\"$gs->sec\">Edit</a> <a class=\" btn-success btn-editi text-xs btn-xs\" data-sec=\"$gs->sec\"><i class=\"fas fa-edit\"></i> Item</a>";
                }
                $totalkgm = $totalkgm + floatval($gs->kgm);



                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $mutasiproduksi2->count_allmutasiproduksi(),
                "recordsFiltered" => $mutasiproduksi2->count_filteredmutasiproduksi($datafilter),
                "rendered" => $rendered,
                "totalqty" => number_format($totalqty, 2),
                "totalkgm" => number_format($totalkgm, 2),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}
