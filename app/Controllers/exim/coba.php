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

class Mutasiproduksi extends BaseController
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

        $lok = $this->saldoawal->Lokasi();
        $aju = $this->saldoawal->Aju();
        $item = $this->mutasiproduksi->Allitem();
        $analyst = $this->mutasiproduksi->Allanalyst();

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'aju' => $aju,
            'lok' => $lok,
            'item' => $item,
            'analyst' => $analyst,
            'halaman' => 'Mutasi Produksi',
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/bjadi/mutasiproduksi/index', $data);
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

    public function Edit()
    {
        if ($this->request->isAJAX()) {

            $aju = $this->mutasiproduksi->Aju();

            $id = $this->request->getPost('id');


            $editmutasiproduksi = $this->mutasiproduksi->Edit($id);

            $data = [
                'aju' => $aju,
                'edit' => $editmutasiproduksi,

            ];
            $msg = [
                'sukses' => view('exim/bjadi/mutasiproduksi/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Editm()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $lok = $this->saldoawal->Lokasi();

            $id = $this->request->getPost('id');


            $editmutasiproduksi = $this->mutasiproduksi->Editm($id);

            $data = [
                'lok' => $lok,
                'edit' => $editmutasiproduksi,

            ];
            $msg = [
                'sukses' => view('exim/bjadi/mutasiproduksi/editm', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Editi()
    {
        if ($this->request->isAJAX()) {

            $item = $this->mutasiproduksi->Allitem();

            $id = $this->request->getPost('id');


            $editmutasiproduksi = $this->mutasiproduksi->Editi($id);

            $data = [
                'item' => $item,
                'edit' => $editmutasiproduksi,

            ];
            $msg = [
                'sukses' => view('exim/bjadi/mutasiproduksi/editi', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Addaju()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $aju = $this->saldoawal->Aju();
            $item = $this->mutasiproduksi->Allitem();

            $id = $this->request->getPost('id');


            $addaju = $this->mutasiproduksi->find($id);

            $data = [
                'aju' => $aju,
                'item' => $item,
                'add' => $addaju,

            ];
            $msg = [
                'sukses' => view('exim/bjadi/mutasiproduksi/addaju', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Save()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $sec = htmlspecialchars($this->request->getPost('sec'));
                $no_aju = htmlspecialchars($this->request->getPost('no_aju'));
                $code = htmlspecialchars($this->request->getPost('code'));
                //$item = htmlspecialchars($this->request->getPost('item'));
                $qty = htmlspecialchars($this->request->getPost('qty'));
                $kgm = htmlspecialchars($this->request->getPost('kgm'));


                $dtl = [
                    'no_aju' => $no_aju,
                    //'item' => $item,
                    'qty' => $qty,
                    'kg' => $kgm,
                    'iduser' => user()->username,
                    'code' => $code,
                ];

                $dataupdate = $this->mutasiproduksi->where('sec', $sec)->set($dtl)->update();

                if ($dataupdate) {
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

    public function Savem()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $sec = htmlspecialchars($this->request->getPost('sec'));
                $tgl = $this->request->getPost('tgl');
                $loka = $this->request->getPost('lokasal');
                $lokt = $this->request->getPost('loktujuan');

                $kodloka = $this->mutasiproduksi->Kodelok2($loka);
                $kodlokt = $this->mutasiproduksi->Kodelok2($lokt);

                $tgls = date('d', strtotime($tgl));
                $bln = date('m', strtotime($tgl));
                $thn = date('y', strtotime($tgl));
                $nosurat = $tgls . '/' . $kodloka['analyst_code'] . '/' . $kodlokt['analyst_code'] . '/' . $bln . '/' . $thn;

                $bulantahun =  '/' . $bln . '/' . $thn;
                $datainput = [
                    'bulantahun' => $bulantahun,
                    'lokasal' => $kodloka['analyst_code']
                ];

                $cekhdr = $this->mutasiproduksi->Ceksurat($nosurat);
                if ($cekhdr == 0) {

                    $cekhdrbon = $this->mutasiproduksi->Ceksuratbon($datainput);

                    if ($cekhdrbon > 0) {
                        $nohdrmax = $this->mutasiproduksi->Nomaxhdr($datainput);
                        $no = trim('/', $nohdrmax);
                        $nourut = $no + 1;
                        $tambahmutasihdr = [
                            'kode' => $nosurat,
                            'tgl' => $tgl,
                            'lokasi_asal' => $loka,
                            'lokasi_tujuan' => $lokt,
                            'analyst_asal' => $kodloka['analyst_code'],
                            'analyst_tujuan' => $kodlokt['analyst_code'],
                            'kode2' => $nourut . '/' . $nosurat,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                    } else {
                        $nourut = 1;
                        $tambahmutasihdr = [
                            'kode' => $nosurat,
                            'tgl' => $tgl,
                            'lokasi_asal' => $kodloka['Analyst'],
                            'lokasi_tujuan' => $kodlokt['Analyst'],
                            'analyst_asal' => $loka,
                            'analyst_tujuan' => $lokt,
                            'kode2' => $nourut . '/' . $nosurat,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                    }
                    $savehdr = $this->mutasiproduksi->Addmutasihdr($tambahmutasihdr);
                }

                $dtl = [
                    'iduser' => user()->username,
                    'kode' => $nosurat,
                ];

                $dataupdate = $this->mutasiproduksi->where('sec', $sec)->set($dtl)->update();

                if ($dataupdate) {
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

    public function Savei()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $sec = htmlspecialchars($this->request->getPost('sec'));
                $item = htmlspecialchars($this->request->getPost('item'));


                $dtl = [
                    'item' => $item,
                    'iduser' => user()->username,
                ];

                $dataupdate = $this->mutasiproduksi->where('sec', $sec)->set($dtl)->update();

                if ($dataupdate) {
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

    public function Saveaju()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $sec = htmlspecialchars($this->request->getPost('sec'));
                $kode = htmlspecialchars($this->request->getPost('kode'));
                $item = htmlspecialchars($this->request->getPost('item'));
                $aju = htmlspecialchars($this->request->getPost('no_aju'));
                $qty = htmlspecialchars($this->request->getPost('qty'));
                $kgm = htmlspecialchars($this->request->getPost('kgm'));


                $dtl = [
                    'kode' => $kode,
                    'item' => $item,
                    'ln' => '0',
                    'no_aju' => $aju,
                    'qty' => $qty,
                    'kg' => $kgm,
                    'iduser' => user()->username,
                    'code' => '2'
                ];

                $dataupdate = $this->mutasiproduksi->save($dtl);

                if ($dataupdate) {
                    session()->setFlashdata('success', 'nambah aju data berhasil');
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

    public function Addmutasiproduksi()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'tgl' => [
                        'label'  => 'tgl',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Tanggal harus Diisi !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $kode_item = $this->request->getPost('itemdes');
                    $code = $this->request->getPost('code');
                    $qty_awal = $this->request->getPost('qty_awal');
                    $netto_awal = $this->request->getPost('netto_awal');
                    $tgl = $this->request->getPost('tgl');
                    $loka = $this->request->getPost('lokasal');
                    $lokt = $this->request->getPost('loktujuan');
                    $aju = $this->request->getPost('aju');

                    $kodloka = $this->mutasiproduksi->Kodelok2($loka);
                    $kodlokt = $this->mutasiproduksi->Kodelok2($lokt);

                    $tgls = date('d', strtotime($tgl));
                    $bln = date('m', strtotime($tgl));
                    $thn = date('y', strtotime($tgl));
                    $nosurat = $tgls . '/' . $kodloka['analyst_code'] . '/' . $kodlokt['analyst_code'] . '/' . $bln . '/' . $thn;

                    $bulantahun =  '/' . $bln . '/' . $thn;
                    $datainput = [
                        'bulantahun' => $bulantahun,
                        'lokasal' => $kodloka['analyst_code']
                    ];

                    $tambahmutasidtl = [
                        'kode' => $nosurat,
                        'item' => $kode_item,
                        'qty' => $qty_awal,
                        'kg' => $netto_awal,
                        'no_aju' => $aju,
                        'code' => $code,
                        'iduser' => user()->username,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];

                    $cekhdr = $this->mutasiproduksi->Ceksurat($nosurat);

                    if ($cekhdr == 0) {

                        $cekhdrbon = $this->mutasiproduksi->Ceksuratbon($datainput);

                        if ($cekhdrbon > 0) {
                            $nohdrmax = $this->mutasiproduksi->Nomaxhdr($datainput);
                            $no = trim('/', $nohdrmax);
                            $nourut = $no + 1;
                            $tambahmutasihdr = [
                                'kode' => $nosurat,
                                'tgl' => $tgl,
                                'lokasi_asal' => $loka,
                                'lokasi_tujuan' => $lokt,
                                'analyst_asal' => $kodloka['analyst_code'],
                                'analyst_tujuan' => $kodlokt['analyst_code'],
                                'kode2' => $nourut . '/' . $nosurat,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ];
                        } else {
                            $nourut = 1;
                            $tambahmutasihdr = [
                                'kode' => $nosurat,
                                'tgl' => $tgl,
                                'lokasi_asal' => $kodloka['Analyst'],
                                'lokasi_tujuan' => $kodlokt['Analyst'],
                                'analyst_asal' => $loka,
                                'analyst_tujuan' => $lokt,
                                'kode2' => $nourut . '/' . $nosurat,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ];
                        }
                        $savehdr = $this->mutasiproduksi->Addmutasihdr($tambahmutasihdr);
                    }


                    $save = $this->mutasiproduksi->Addmutasidtl($tambahmutasidtl);
                    // $msg = [
                    //     'success' => $cekhdr,
                    // ];

                    if ($save) {
                        $msg = [
                            'success' => 'berhasil',
                        ];
                    } else {
                        $msg = [
                            'error' => 'data masuk error'
                        ];
                    }
                } else {
                    $msg = [
                        'error' => $this->validator->listErrors()
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function Searchkodeitem()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $namaitem = $this->request->getPost("namaitem");

            $dataitem = $this->saldoawal->Allitem($namaitem);

            $data = [
                'kodeitem' => $dataitem['item']
            ];

            echo json_encode($data);
        }
    }

    public function Deletemutasiproduksi()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $sec = htmlspecialchars($this->request->getPost('sec'));

            if ($sec) {
                $delete = $this->mutasiproduksi->delete($sec);
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
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