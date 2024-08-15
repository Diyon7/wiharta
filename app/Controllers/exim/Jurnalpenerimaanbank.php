<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\barangjadi\Saldoawal_model;
use App\Models\exim\barangjadi\MutasiProduksi_model;
use App\Models\exim\Useritv_model;
use App\Models\exim\jurnal\Jurnalpembelian_model;
use App\Models\exim\jurnal\Jurnalpenerimaanbank_model;
use App\Models\exim\jurnal\Jurnalpenerimaanbankdetail_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Jurnalpenerimaanbank extends BaseController
{

    protected $saldoawal;
    protected $mutasiproduksi;
    protected $useritv;
    protected $jurnalpembelian;
    protected $jurnalpenerimaanbank;
    protected $jurnalpenerimaanbankdetail;

    public function __construct()
    {
        $this->saldoawal = new Saldoawal_model();
        $this->mutasiproduksi = new MutasiProduksi_model();
        $this->useritv = new Useritv_model();
        $this->jurnalpembelian = new Jurnalpembelian_model();
        $this->jurnalpenerimaanbank = new Jurnalpenerimaanbank_model();
        $this->jurnalpenerimaanbankdetail = new Jurnalpenerimaanbankdetail_model();
    }

    public function Index()
    {

        $bank = $this->jurnalpenerimaanbank->Bank();
        $inv = $this->jurnalpenerimaanbank->Inv();
        $aju = $this->jurnalpenerimaanbank->Aju();

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Jurnal Penerimaan Bank',
            'bank' => $bank,
            'inv' => $inv,
            'aju' => $aju,
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/jurnal/jurnalpenerimaanbank/index', $data);
    }

    public function Nambah()
    {
        if ($this->request->isAJAX()) {

            $bank = $this->jurnalpenerimaanbank->Bank();
            $inv = $this->jurnalpenerimaanbank->Inv();
            $invbl = $this->jurnalpenerimaanbank->Invbl();
            $aju = $this->jurnalpenerimaanbank->Aju();

            $jumlahloginbc = $this->useritv->Countuserbc();
            $loginterakhirloginbc = $this->useritv->Maxuserbc();

            $data = [
                'title' => 'WKA INFORMATION SYSTEM',
                'devisi' => 'Karyawan',
                'halaman' => 'Jurnal Penerimaan Bank',
                'bank' => $bank,
                'inv' => $inv,
                'invbl' => $invbl,
                'aju' => $aju,
            ];
            $msg = [
                'sukses' => view('exim/jurnal/jurnalpenerimaanbank/add', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Edit()
    {
        if ($this->request->isAJAX()) {

            $bank = $this->jurnalpenerimaanbank->Bank();
            $inv = $this->jurnalpenerimaanbank->Inv();
            $invbl = $this->jurnalpenerimaanbank->Invbl();
            $aju = $this->jurnalpenerimaanbank->Aju();

            $id = $this->request->getPost('id');

            $editpenerimaanbank = $this->jurnalpenerimaanbank->Edit($id);
            $editpenerimaanbankdetail = $this->jurnalpenerimaanbankdetail->Edit($id);

            $data = [
                'bank' => $bank,
                'inv' => $inv,
                'invbl' => $invbl,
                'aju' => $aju,
                'edit' => $editpenerimaanbank,
                'editdetail' => $editpenerimaanbankdetail
            ];
            $msg = [
                'sukses' => view('exim/jurnal/jurnalpenerimaanbank/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Serversideinv()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $inv = $this->request->getPost("inv");

            $datainv = $this->jurnalpenerimaanbank->Searchdatafrominv($inv);

            foreach ($datainv as $di) {
                $kgm[] = $di['kgm'];
                $piutang[] = $di['nilai'];
                $inv = $di['inv'];
                $tglpeb = $di['tglpeb'];
                $peb = $di['peb'];
                $cus = $di['cus'];
            }
            $data = [
                'kgm' => $kgm,
                'piutang' => $piutang,
                'inv' => $inv,
                'tglpeb' => $tglpeb,
                'peb' => $peb,
                'cus' => $cus,
            ];

            echo json_encode($data);
        }
    }
    public function Serversideaju()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $aju = $this->request->getPost("aju");

            $datainv = $this->jurnalpenerimaanbank->Searchdatafromaju($aju);

            foreach ($datainv as $di) {
                $kgm[] = $di['kgm'];
                $nilai[] = $di['nilai'];
                $aju = $di['aju'];
                $tglbapb = $di['tglbapb'];
            }
            $data = [
                'kgm' => $kgm,
                'nilai' => $nilai,
                'aju' => $aju,
                'tglbapb' => $tglbapb,
            ];

            echo json_encode($data);
        }
    }

    public function Addjurnalpenerimaanbank()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'bank' => [
                        'label'  => 'bank',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Bank harus Diklik !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $bank = $this->request->getPost('bank');
                    $kodereferensi = $this->request->getPost('kodereferensi');
                    $inv = $this->request->getPost('inv');
                    $tglpeb = $this->request->getPost('tglpeb');
                    $tgl = $this->request->getPost('tgl');
                    $nilaibank = $this->request->getPost('nilaibank');
                    $biaya = $this->request->getPost('biaya');
                    $aju = $this->request->getPost('aju');
                    $tglaju = $this->request->getPost('tglaju');
                    $customer = $this->request->getPost('customer');
                    $peb = $this->request->getPost('peb');
                    $hutang = $this->request->getVar('hutang');
                    $piutang = $this->request->getVar('piutang');
                    $kgmpib = $this->request->getVar('kgmpib');
                    $kgmpeb = $this->request->getVar('kgmpeb');
                    $mu = 'USD';
                    $kurs = '0';


                    if (is_null($hutang)) {
                        $jh = 0;
                    } else {
                        $jh = count($hutang);
                    }

                    if (is_null($piutang)) {
                        $jp = 0;
                    } else {
                        $jp = count($piutang);
                    }

                    if ($jh < $jp) {
                        $jw = $jp;
                    } elseif ($jp < $jh) {
                        $jw = $jh;
                    } elseif ($jp == $jh) {
                        $jw = $jh;
                    }


                    $bulan = date("m", strtotime($tgl));
                    $tahun = date("Y", strtotime($tgl));

                    $tglquery = [
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                    ];

                    $codedb = $this->jurnalpenerimaanbank->Codedb($tglquery);

                    $nourut = '0001';

                    if ($cek = $codedb > 0) {
                        $codedb2 = $this->jurnalpenerimaanbank->Codedb2($tglquery);
                        $no = $codedb2['kode'];
                        $no2 = $no + 1;
                        $nourut =  sprintf("%04s", $no2);
                    }

                    $kode = "INB/FIN/$tahun/$bulan/$nourut";

                    $user = user()->username;

                    $input1 = [
                        'kode' => $kode,
                        'kode_bank' => $bank,
                        'tgl' => $tgl,
                        'kode_referensi' => $kodereferensi,
                        'peb' => $peb,
                        'tgl_peb' => $tglpeb,
                        'aju' => $aju,
                        'tgl_pib' => $tglaju,
                        'inv' => $inv,
                        'biayabank' => $nilaibank,
                        'customer' => $customer,
                        'nilai' => $biaya,
                        'mu' => $mu,
                        'kurs' => $kurs,
                        'user' => user()->username,
                    ];

                    $insertpb = $this->jurnalpenerimaanbank->insert($input1);
                    for ($i = 0; $i < $jw; $i++) {
                        if (isset($hutang[$i])) {
                            $hp = $hutang[$i];
                        } else {
                            $hp = '0';
                        }
                        if (isset($piutang[$i])) {
                            $hpp = $piutang[$i];
                        } else {
                            $hpp = '0';
                        }
                        if (isset($kgmpib[$i])) {
                            $kp = $kgmpib[$i];
                        } else {
                            $kp = '0';
                        }
                        if (isset($hutang[$i])) {
                            $kpp = $kgmpeb[$i];
                        } else {
                            $kpp = '0';
                        }
                        $input2 = [
                            'kode' => $kode,
                            'kode_bank' => $bank,
                            'tgl' => $tgl,
                            'kgm_peb' => $kpp,
                            'nilai_peb' => $hpp,
                            'biayabank' => $nilaibank,
                            'kgm_pib' => $kp,
                            'nilai_pib' => $hp,
                            'mu' => $mu,
                            'kurs' => $kurs,
                        ];
                        $insertpbd = $this->jurnalpenerimaanbankdetail->save($input2);
                    };

                    if ($insertpbd) {
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

    public function Saveeditjurnalpenerimaanbank()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'bank' => [
                        'label'  => 'bank',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Bank harus Diklik !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $kode = $this->request->getPost('kode');
                    $bank = $this->request->getPost('bank');
                    $kodereferensi = $this->request->getPost('kodereferensi');
                    $inv = $this->request->getPost('inv');
                    $tglpeb = $this->request->getPost('tglpeb');
                    $tgl = $this->request->getPost('tgl');
                    $nilaibank = $this->request->getPost('nilaibank');
                    $biaya = $this->request->getPost('biaya');
                    $aju = $this->request->getPost('aju');
                    $tglaju = $this->request->getPost('tglaju');
                    $customer = $this->request->getPost('customer');
                    $peb = $this->request->getPost('peb');
                    $hutang = $this->request->getVar('hutang');
                    $piutang = $this->request->getVar('piutang');
                    $kgmpib = $this->request->getVar('kgmpib');
                    $kgmpeb = $this->request->getVar('kgmpeb');
                    $mu = 'USD';
                    $kurs = '0';

                    if (is_null($hutang)) {
                        $jh = 0;
                    } else {
                        $jh = count($hutang);
                    }

                    if (is_null($piutang)) {
                        $jp = 0;
                    } else {
                        $jp = count($piutang);
                    }

                    if ($jh < $jp) {
                        $jw = $jp;
                    } elseif ($jp < $jh) {
                        $jw = $jh;
                    } else {
                        $jw = $jh;
                    }

                    $user = user()->username;

                    $input1 = [
                        'kode_bank' => $bank,
                        'tgl' => $tgl,
                        'kode_referensi' => $kodereferensi,
                        'peb' => $peb,
                        'tgl_peb' => $tglpeb,
                        'aju' => $aju,
                        'tgl_pib' => $tglaju,
                        'inv' => $inv,
                        'biayabank' => $nilaibank,
                        'customer' => $customer,
                        'nilai' => $biaya,
                        'mu' => $mu,
                        'kurs' => $kurs,
                        'user' => user()->username,
                    ];

                    $insertpb = $this->jurnalpenerimaanbank->where('kode', $kode)->set($input1)->update();
                    $delete = $this->jurnalpenerimaanbankdetail->where('kode', $kode)->delete();
                    for ($i = 0; $i < $jw; $i++) {
                        if (isset($hutang[$i])) {
                            $hp = $hutang[$i];
                        } else {
                            $hp = '0';
                        }
                        if (isset($piutang[$i])) {
                            $hpp = $piutang[$i];
                        } else {
                            $hpp = '0';
                        }
                        if (isset($kgmpib[$i])) {
                            $kp = $kgmpib[$i];
                        } else {
                            $kp = '0';
                        }
                        if (isset($hutang[$i])) {
                            $kpp = $kgmpeb[$i];
                        } else {
                            $kpp = '0';
                        }
                        $input2 = [
                            'kode' => $kode,
                            'kode_bank' => $bank,
                            'tgl' => $tgl,
                            'kgm_peb' => $kpp,
                            'nilai_peb' => $hpp,
                            'biayabank' => $nilaibank,
                            'kgm_pib' => $kp,
                            'nilai_pib' => $hp,
                            'mu' => $mu,
                            'kurs' => $kurs,
                        ];
                        $insertpbd = $this->jurnalpenerimaanbankdetail->save($input2);
                    };

                    if ($insertpbd) {
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

    public function Deletejurnal()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $kode = $this->request->getPost('kode');

                $insertpb = $this->jurnalpenerimaanbank->where('kode', $kode)->delete();
                $delete = $this->jurnalpenerimaanbankdetail->where('kode', $kode)->delete();

                if ($delete) {
                    $msg = [
                        'success' => 'berhasil',
                    ];
                } else {
                    $msg = [
                        'error' => 'data masuk error'
                    ];
                }

                echo json_encode($msg);
            }
        }
    }

    function Cetakkode()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');

            $datajurnal = $this->jurnalpenerimaanbank->Cetakkode($id);
            $datapibjurnal = $this->jurnalpenerimaanbank->Cetakpibkode($id);
            $datapebjurnal = $this->jurnalpenerimaanbank->Cetakpebkode($id);

            $data = [
                'jur' => $datajurnal,
                'datapib' => $datapibjurnal,
                'datapeb' => $datapebjurnal
            ];

            $tampiltabel = [
                'sukses' => view('exim/jurnal/jurnalpenerimaanbank/pdfkode', $data)
            ];
            echo json_encode($tampiltabel);
        }
    }

    public function Datatablesjurnalpenerimaanbank()
    {

        $tgldari = $this->request->getPost('tgldari');
        $tglke = $this->request->getPost('tglke');

        $totalqty = 0;
        $totalkgm = 0;

        $datafilter = [
            'tgldari' => $tgldari,
            'tglke' => $tglke,
        ];

        $request = Services::request();
        $jurnalpenerimaanbank = new Jurnalpenerimaanbank_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $jurnalpenerimaanbank->get_datatablesjurnalpenerimaanbank($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->namabank;
                $row[] = $gs->tgl;
                $row[] = $gs->peb;
                $row[] = $gs->tgl_peb;
                $row[] = $gs->inv;
                $row[] = $gs->pelanggan;
                $row[] = $gs->biayabank;
                $row[] = $gs->mu;
                $row[] = $gs->updated_at;
                $row[] = "<a class=\"btn-edit btn-primary text-xs btn-xs\" data-kode=\"$gs->kode\"><i class=\"fas fa-edit\"></i></a><a class=\"btn-delete btn-danger text-xs btn-xs\" data-kode=\"$gs->kode\"><i class=\"fas fa-trash\"></i></a><a class=\" btn-success btn-print text-xs btn-xs\" data-kode=\"$gs->kode\"><i class=\"fas fa-print\"></i></a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $jurnalpenerimaanbank->count_alljurnalpenerimaanbank(),
                "recordsFiltered" => $jurnalpenerimaanbank->count_filteredjurnalpenerimaanbank($datafilter),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}