<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\barangjadi\Saldoawal_model;
use App\Models\exim\barangjadi\MutasiProduksi_model;
use App\Models\exim\Useritv_model;
use App\Models\exim\jurnal\Jurnalpembelian_model;
use App\Models\exim\jurnal\Jurnalpengeluaranbank_model;
use App\Models\exim\jurnal\jurnalpengeluaranbankdetail_model;
use App\Models\exim\jurnal\Jurnalpengeluaranbankpeb_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Jurnalpengeluaranbank extends BaseController
{

    protected $saldoawal;
    protected $mutasiproduksi;
    protected $useritv;
    protected $jurnalpembelian;
    protected $jurnalpengeluaranbank;
    protected $jurnalpengeluaranbankdetail;
    protected $jurnalpengeluaranbankpeb;

    public function __construct()
    {
        $this->saldoawal = new Saldoawal_model();
        $this->mutasiproduksi = new MutasiProduksi_model();
        $this->useritv = new Useritv_model();
        $this->jurnalpembelian = new Jurnalpembelian_model();
        $this->jurnalpengeluaranbank = new jurnalpengeluaranbank_model();
        $this->jurnalpengeluaranbankdetail = new jurnalpengeluaranbankdetail_model();
        $this->jurnalpengeluaranbankpeb = new jurnalpengeluaranbankpeb_model();
    }

    public function Index()
    {

        $bank = $this->jurnalpengeluaranbank->Bank();
        $aju = $this->jurnalpengeluaranbank->Aju();

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Jurnal Pengeluaran Bank',
            'bank' => $bank,
            'aju' => $aju,
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/jurnal/jurnalpengeluaranbank/index', $data);
    }

    public function Tambah()
    {
        if ($this->request->isAJAX()) {


            $bank = $this->jurnalpengeluaranbank->Bank();
            $inv = $this->jurnalpengeluaranbank->Inv();
            // $invbl = $this->jurnalpengeluaranbank->Invbl();
            $aju = $this->jurnalpengeluaranbank->Aju();
            $jumlahloginbc = $this->useritv->Countuserbc();
            $loginterakhirloginbc = $this->useritv->Maxuserbc();

            $data = [
                'title' => 'WKA INFORMATION SYSTEM',
                'devisi' => 'Karyawan',
                'bank' => $bank,
                'inv' => $inv,
                // 'invbl' => $invbl,
                'aju' => $aju,
                'halaman' => 'Jurnal Penerimaan Bank',
            ];
            $msg = [
                'sukses' => view('exim/jurnal/jurnalpengeluaranbank/add', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Edit()
    {
        if ($this->request->isAJAX()) {

            $bank = $this->jurnalpengeluaranbank->Bank();
            $inv = $this->jurnalpengeluaranbank->Inv();
            $aju = $this->jurnalpengeluaranbank->Aju();

            $id = $this->request->getPost('id');

            $jurnalpengeluaranbank = $this->jurnalpengeluaranbank->Edit($id);
            $jurnalpengeluaranbankdetail = $this->jurnalpengeluaranbankdetail->Edit($id);
            $jurnalpengeluaranbankpeb = $this->jurnalpengeluaranbankpeb->Edit($id);

            $data = [
                'id' => $id,
                'bank' => $bank,
                'inv' => $inv,
                'aju' => $aju,
                'edit' => $jurnalpengeluaranbank,
                'editdetail' => $jurnalpengeluaranbankdetail,
                'editpeb' => $jurnalpengeluaranbankpeb,
            ];
            $msg = [
                'sukses' => view('exim/jurnal/jurnalpengeluaranbank/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Deletejurnal()
    {
        if ($this->request->isAJAX()) {

            $kode = $this->request->getPost('kode');

            $deletejurnal = $this->jurnalpengeluaranbank->where('kode', $kode)->delete();
            $deletejurnaldetail = $this->jurnalpengeluaranbankdetail->where('kode', $kode)->delete();

            if ($deletejurnaldetail) {
                $msg = [
                    'success' => 'data berhasil'
                ];
            } else {
                $msg = [
                    'error' => 'data belum berhasil dihapus'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function Serversideinv()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $inv = $this->request->getPost("inv");

            $datainv = $this->jurnalpengeluaranbank->Searchdatafrominv($inv);

            foreach ($datainv as $di) {
                $kgm[] = $di['kgm'];
                $nilai[] = $di['nilai'];
                $inv = $di['inv'];
                $tglpeb = $di['tglpeb'];
                $peb = $di['peb'];
                $cus = $di['cus'];
            }
            $data = [
                'kgm' => $kgm,
                'nilai' => $nilai,
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

            $dataaju = $this->jurnalpengeluaranbank->Searchdatafromaju($aju);

            foreach ($dataaju as $da) {
                $vendor = $da['vendor'];
                $dataaju = $da['aju'];
                $bapb = $da['bapb'];
                $tglbapb = $da['tglbapb'];
                $nilai[] = $da['nilai'];
            }

            $data = [
                'vendor' => $vendor,
                'aju' => $dataaju,
                'bapb' => $bapb,
                'tglbapb' => $tglbapb,
                'nilai' => $nilai,
            ];

            echo json_encode($data);
        }
    }

    public function Addjurnalpengeluaranbank()
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
                    $bankcharge = $this->request->getPost('bankcharge');
                    $asuransi = $this->request->getPost('asuransi');
                    $ongkosangkut = $this->request->getPost('ongkosangkut');
                    $tgl = $this->request->getPost('tgl');
                    $aju = $this->request->getPost('aju');
                    $inv = $this->request->getPost('inv');
                    $supplier = $this->request->getPost('supplier');
                    $bapb = $this->request->getPost('bapb');
                    $tglbapb = $this->request->getVar('tglbapb');
                    $nilaiinv = $this->request->getVar('nilaiinv');
                    $nilai = $this->request->getVar('nilai');
                    $nilai2 = $this->request->getVar('nilai2');
                    $nilaiu = $this->request->getVar('nilaiu');
                    $mu = 'USD';
                    $kurs = '0';

                    $bulan = date("m", strtotime($tgl));
                    $tahun = date("Y", strtotime($tgl));


                    if (is_null($nilaiu)) {
                        $jnu = 0;
                    } else {
                        $jnu = count($nilaiu);
                    }
                    if (is_null($nilaiinv)) {
                        $jnv = 0;
                    } else {
                        $jnv = count($nilaiinv);
                    }

                    $jnilaiv = $jnv;

                    $jnilai = $jnu;

                    $tglquery = [
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                    ];

                    $codedb = $this->jurnalpengeluaranbank->Codedb($tglquery);

                    $nourut = '0001';

                    if ($cek = $codedb > 0) {
                        $codedb2 = $this->jurnalpengeluaranbank->Codedb2($tglquery);
                        $no = $codedb2['kode'];
                        $no2 = $no + 1;
                        $nourut =  sprintf("%04s", $no2);
                    }

                    $kode = "JPB/FIN/$tahun/$bulan/$nourut";

                    $input1 = [
                        'kode' => $kode,
                        'kode_bank' => $bank,
                        'tgl' => $tgl,
                        'kode_referensi' => $kodereferensi,
                        'biayabank' => $bankcharge,
                        'biayaasuransi' => $asuransi,
                        'biayatransport' => $ongkosangkut,
                        'aju' => $aju,
                        'inv' => $inv,
                        'bapb' => $bapb,
                        'tgl_bapb' => $tglbapb,
                        'supplier' => $supplier,
                        'nilai2' => $nilai2,
                        'nilai' => $nilai[0],
                        'mu' => $mu,
                        'kurs' => $kurs,
                        'user' => user()->username,
                    ];

                    $insertpb = $this->jurnalpengeluaranbank->insert($input1);

                    for ($i = 0; $i < $jnilai; $i++) {
                        if (isset($nilai[$i])) {
                            $njp = $nilai[$i];
                        } else {
                            $njp = '0';
                        }
                        if (isset($nilaiu[$i])) {
                            $njpu = $nilaiu[$i];
                        } else {
                            $njpu = '0';
                        }
                        $input2 = [
                            'kode' => $kode,
                            'kode_bank' => $bank,
                            'tgl' => $tgl,
                            'nilai' => $njp,
                            'mu' => $mu,
                            'kurs' => $kurs,
                            'debit' => $njp,
                            'kredit' => $njpu,
                        ];
                        $insertpbd = $this->jurnalpengeluaranbankdetail->insert($input2);
                    };
                    for ($i = 0; $i < $jnilaiv; $i++) {
                        if (isset($nilaiinv[$i])) {
                            $njv = $nilaiinv[$i];
                        } else {
                            $njv = '0';
                        }
                        $input3 = [
                            'kode' => $kode,
                            'nilai_peb' => $njv,
                        ];
                        $insertpbv = $this->jurnalpengeluaranbankpeb->insert($input3);
                    };

                    if ($insertpbd) {
                        $msg = [
                            'success' => 'berhasil',
                        ];
                    } else {
                        $msg = [
                            'kode' => $kode,
                            'kode_bank' => $bank,
                            'tgl' => $tgl,
                            'kode_referensi' => $kodereferensi,
                            'aju' => $aju,
                            'bapb' => $bapb,
                            'tgl_bapb' => $tglbapb,
                            'supplier' => $supplier,
                            'nilai' => $nilai,
                            'mu' => $mu,
                            'kurs' => $kurs,
                            'user' => user()->username,
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

    public function Saveeditjurnalpengeluaranbank()
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
                    $bankcharge = $this->request->getPost('bankcharge');
                    $asuransi = $this->request->getPost('asuransi');
                    $ongkosangkut = $this->request->getPost('ongkosangkut');
                    $tgl = $this->request->getVar('tgl');
                    $aju = $this->request->getPost('aju');
                    $inv = $this->request->getPost('inv');
                    $supplier = $this->request->getPost('supplier');
                    $bapb = $this->request->getPost('bapb');
                    $tglbapb = $this->request->getPost('tglbapb');
                    $nilaiinv = $this->request->getVar('nilaiinv');
                    $nilai = $this->request->getVar('nilai');
                    $nilai2 = $this->request->getVar('nilai2');
                    $nilaiu = $this->request->getVar('nilaiu');
                    $mu = 'USD';
                    $kurs = '0';

                    if (is_null($nilaiinv)) {
                        $jnv = 0;
                    } else {
                        $jnv = count($nilaiinv);
                    }

                    if (is_null($nilaiu)) {
                        $jnu = 0;
                    } else {
                        $jnu = count($nilaiu);
                    }

                    $jnilaiv = $jnv;
                    $jnilai = $jnu;

                    $user = user()->username;

                    $input1 = [
                        'kode' => $kode,
                        'kode_bank' => $bank,
                        // 'tgl' => $tgl,
                        'kode_referensi' => $kodereferensi,
                        'biayabank' => $bankcharge,
                        'biayaasuransi' => $asuransi,
                        'biayatransport' => $ongkosangkut,
                        'aju' => $aju,
                        'inv' => $inv,
                        'bapb' => $bapb,
                        'tgl_bapb' => $tglbapb,
                        'supplier' => $supplier,
                        'nilai2' => $nilai2,
                        'nilai' => $nilai[0],
                        'user' => user()->username,
                    ];
                    $insertpb = $this->jurnalpengeluaranbank->where('kode', $kode)->set($input1)->update();
                    $insertpbd = $this->jurnalpengeluaranbankdetail->where('kode', $kode)->delete();
                    $insertpbv = $this->jurnalpengeluaranbankpeb->where('kode', $kode)->delete();
                    for ($i = 0; $i < $jnilai; $i++) {
                        if (isset($nilai[$i])) {
                            $njp = $nilai[$i];
                        } else {
                            $njp = '0';
                        }
                        if (isset($nilaiu[$i])) {
                            $njpu = $nilaiu[$i];
                        } else {
                            $njpu = '0';
                        }
                        if (isset($tgl[$i])) {
                            $jpl = $tgl[$i];
                        } else {
                            $jpl = $tgl[0];
                        }
                        $input2 = [
                            'kode' => $kode,
                            'kode_bank' => $bank,
                            'tgl' => $jpl,
                            'mu' => $mu,
                            'kurs' => $kurs,
                            'nilai' => $njp,
                            'debit' => $njp,
                            'kredit' => $njpu,
                        ];
                        $insertpbd = $this->jurnalpengeluaranbankdetail->insert($input2);
                    };
                    for ($i = 0; $i < $jnilaiv; $i++) {
                        if (isset($nilaiinv[$i])) {
                            $jpv = $nilaiinv[$i];
                        } else {
                            $jpv = '0';
                        }

                        $input3 = [
                            'kode' => $kode,
                            'nilai_peb' => $jpv,
                        ];
                        $insertpbd = $this->jurnalpengeluaranbankpeb->insert($input3);
                    };

                    if ($insertpbd) {
                        $msg = [
                            'success' => 'berhasil',
                        ];
                    } else {
                        $msg = [
                            'error' => $kode
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

    function Cetakkode()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');

            $datajurnal = $this->jurnalpengeluaranbank->Cetakkode($id);

            $data = [
                'datajurnal' => $datajurnal,
            ];

            $tampiltabel = [
                'sukses' => view('exim/jurnal/jurnalpengeluaranbank/pdfkode', $data)
            ];
            echo json_encode($tampiltabel);
        }
    }

    public function Datatablesjurnalpengeluaranbank()
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
        $jurnalpengeluaranbank = new jurnalpengeluaranbank_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $jurnalpengeluaranbank->get_datatablesjurnalpengeluaranbank($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->namabank;
                $row[] = $gs->tgl;
                $row[] = $gs->aju;
                $row[] = $gs->bapb;
                $row[] = $gs->tgl_bapb;
                $row[] = $gs->supplier;
                if ($gs->selisih < "0") {
                    $row[] = "Belum Lunas";
                } elseif ($gs->selisih > "0") {
                    $row[] = "Perhitungan salah";
                } else {
                    $row[] = "Lunas";
                }
                // $row[] = $gs->nilai;
                $row[] = $gs->updated_at;
                $row[] = "<a class=\"btn-edit btn-primary text-xs btn-xs\" data-kode=\"$gs->kode\"><i class=\"fas fa-edit\"></i></a><a class=\"btn-delete btn-warning text-xs btn-xs\" data-kode=\"$gs->kode\"><i class=\"fas fa-trash\"></i></a><a class=\" btn-success btn-print text-xs btn-xs\" data-kode=\"$gs->kode\"><i class=\"fas fa-print\"></i></a>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $jurnalpengeluaranbank->count_alljurnalpengeluaranbank(),
                "recordsFiltered" => $jurnalpengeluaranbank->count_filteredjurnalpengeluaranbank($datafilter),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}