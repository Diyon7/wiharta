<?php

namespace App\Controllers\exim;

use App\Controllers\BaseController;
use App\Models\exim\barangjadi\Saldoawal_model;
use App\Models\exim\import\Import_model;
use App\Models\exim\Useritv_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Import extends BaseController
{

    protected $saldoawal;
    protected $import;
    protected $useritv;

    public function __construct()
    {
        $this->useritv = new Useritv_model();
        $this->import = new Import_model();
        $this->saldoawal = new Saldoawal_model();
    }

    public function Index()
    {

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();
        $penjual = $this->import->penjualimport();
        $aju = $this->import->aju();
        $rendered[] = '<p>Page rendered in {elapsed_time} seconds</p>';

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'aju' => $aju,
            'penjual' => $penjual,
            // 'item' => $item,
            'halaman' => 'import Mutasi',
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/import/index', $data);
    }
    public function Rab()
    {

        $aju = $this->saldoawal->Aju();
        // $item = $this->import->Allitem();

        $jumlahloginbc = $this->useritv->Countuserbc();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();
        $rendered[] = '<p>Page rendered in {elapsed_time} seconds</p>';
        $rab = $this->import->Rab();

        $data = [
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'aju' => $aju,
            // 'item' => $item,
            'halaman' => 'import Mutasi',
            'rab' => $rab,
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/import/rab', $data);
    }

    public function Tambah()
    {

        $jumlahloginbc = $this->useritv->Countuserbc();
        $penjual = $this->import->penjualimport();
        $aju = $this->import->aju();
        $loginterakhirloginbc = $this->useritv->Maxuserbc();
        $rendered[] = '<p>Page rendered in {elapsed_time} seconds</p>';

        $data = [
            'penjual' => $penjual,
            'aju' => $aju,
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Exim',
            'halaman' => 'import Mutasi',
            'jumlahuserbc' => $jumlahloginbc['user'],
            'loginterakhirloginbc' => $loginterakhirloginbc['datetime'],
        ];

        return view('exim/import/add', $data);
    }

    public function Edit()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $id = $this->request->getPost('id');
            $penjual = $this->import->penjualimport();
            $aju = $this->import->aju();
            $dataimport = $this->import->Dataimport($id);

            $data = [
                'penjual' => $penjual,
                'aju' => $aju,
                'dataimport' => $dataimport,
            ];
            $msg = [
                'sukses' => view('exim/import/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Saveedit()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'fasilitas' => [
                        'label'  => 'fasilitas',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Tanggal harus Diisi !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $seq = htmlspecialchars($this->request->getPost('seq'));
                    $fasilitas = $this->request->getPost('fasilitas');
                    $kode_item = $this->request->getPost('kodeitem');
                    $aju = $this->request->getPost('aju');
                    $nocoo = $this->request->getPost('nocoo');
                    $tglcoo = $this->request->getPost('tglcoo');
                    $penjual = $this->request->getPost('penjual');
                    $emklptj = $this->request->getPost('emklptj');
                    $pib = $this->request->getPost('pib');
                    $tglpib = $this->request->getPost('tglpib');
                    $qty = $this->request->getPost('qty');
                    $kgm = $this->request->getPost('kgm');
                    $nilai = $this->request->getPost('nilai');
                    $hscode = $this->request->getPost('hscode');
                    $bl = $this->request->getPost('bl');
                    $party = $this->request->getPost('party');
                    $etd = $this->request->getPost('etd');
                    $eta = $this->request->getPost('eta');
                    $etawka = $this->request->getPost('etawka');
                    $term = $this->request->getPost('term');
                    $inv = $this->request->getPost('inv');
                    $mu = $this->request->getPost('mu');
                    $nilaipibusd = $this->request->getPost('nilaipibusd');
                    $nilaipibidr = $this->request->getPost('nilaipibidr');
                    $bm = $this->request->getPost('bm');
                    $bmtbmadbmibmpt = $this->request->getPost('bmtbmadbmibmpt');
                    $ppn = $this->request->getPost('ppn');
                    $pph = $this->request->getPost('pph');
                    $remark = $this->request->getPost('remark');
                    $bmdibebaskan = $this->request->getPost('bmdibebaskan');
                    $ppntidakdipungut = $this->request->getPost('ppntidakdipungut');
                    $totalpaymentpib = $this->request->getPost('totalpaymentpib');

                    $namaitem = $this->import->Itemimport($kode_item);

                    $dataimport = [
                        'fasilitas' => $fasilitas,
                        'aju' => $aju,
                        'noaju' => substr($aju, -6),
                        'no_coo' => $nocoo,
                        'tgl_coo' => $tglcoo,
                        'desk' => $namaitem['item_description'],
                        'id_vendor' => $penjual,
                        'emkl_ptj' => $emklptj,
                        'pib' => $pib,
                        'tglpib' => $tglpib,
                        'kode_item' => $kode_item,
                        'itembc' => $namaitem['itembc'],
                        'qty' => $qty,
                        'kgm' => $kgm,
                        'nilai' => $nilai,
                        'hscode' => $hscode,
                        'bl' => $bl,
                        'party' => $party,
                        'etd' => $etd,
                        'eta' => $eta,
                        'eta_wka' => $etawka,
                        'term' => $term,
                        'inv' => $inv,
                        'mu' => $mu,
                        'nilai_pib_usd' => $nilaipibusd,
                        'nilai_pib_idr' => $nilaipibidr,
                        'bm' => $bm,
                        'bmt_bmad_bmi_bmtp' => $bmtbmadbmibmpt,
                        'ppn' => $ppn,
                        'pph' => $pph,
                        'remark' => $remark,
                        'bm_dibebaskan' => $bmdibebaskan,
                        'ppn_tidakdipungut' => $ppntidakdipungut,
                        'total_payment_pib' => $totalpaymentpib,
                        'user' => user()->username
                    ];


                    $save = $this->import->where('seq', $seq)->set($dataimport)->update();

                    if ($save) {
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
    }

    public function Searchitem()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $idata = "";

            $idata = $this->request->getVar("search");

            $dataitem = $this->import->Allitem($idata);

            echo json_encode($dataitem);
        }
    }

    public function Saveimport()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'fasilitas' => [
                        'label'  => 'fasilitas',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Tanggal harus Diisi !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $fasilitas = $this->request->getPost('fasilitas');
                    $kode_item = $this->request->getPost('kodeitem');
                    $aju = $this->request->getPost('aju');
                    $nocoo = $this->request->getPost('nocoo');
                    $tglcoo = $this->request->getPost('tglcoo');
                    $penjual = $this->request->getPost('penjual');
                    $emklptj = $this->request->getPost('emklptj');
                    $pib = $this->request->getPost('pib');
                    $tglpib = $this->request->getPost('tglpib');
                    $qty = $this->request->getPost('qty');
                    $kgm = $this->request->getPost('kgm');
                    $nilai = $this->request->getPost('nilai');
                    $hscode = $this->request->getPost('hscode');
                    $bl = $this->request->getPost('bl');
                    $party = $this->request->getPost('party');
                    $etd = $this->request->getPost('etd');
                    $eta = $this->request->getPost('eta');
                    $etawka = $this->request->getPost('etawka');
                    $term = $this->request->getPost('term');
                    $inv = $this->request->getPost('inv');
                    $mu = $this->request->getPost('mu');
                    $nilaipibusd = $this->request->getPost('nilaipibusd');
                    $nilaipibidr = $this->request->getPost('nilaipibidr');
                    $bm = $this->request->getPost('bm');
                    $bmtbmadbmibmpt = $this->request->getPost('bmtbmadbmibmpt');
                    $ppn = $this->request->getPost('ppn');
                    $pph = $this->request->getPost('pph');
                    $remark = $this->request->getPost('remark');
                    $bmdibebaskan = $this->request->getPost('bmdibebaskan');
                    $ppntidakdipungut = $this->request->getPost('ppntidakdipungut');
                    $totalpaymentpib = $this->request->getPost('totalpaymentpib');

                    $namaitem = $this->import->Itemimport($kode_item);

                    $dataimport = [
                        'fasilitas' => $fasilitas,
                        'aju' => $aju,
                        'noaju' => substr($aju, -6),
                        'no_coo' => $nocoo,
                        'tgl_coo' => $tglcoo,
                        'desk' => $namaitem['item_description'],
                        'id_vendor' => $penjual,
                        'emkl_ptj' => $emklptj,
                        'pib' => $pib,
                        'tglpib' => $tglpib,
                        'kode_item' => $kode_item,
                        // 'desk' => $desk,
                        'itembc' => $namaitem['itembc'],
                        'qty' => $qty,
                        'kgm' => $kgm,
                        'nilai' => $nilai,
                        'hscode' => $hscode,
                        'bl' => $bl,
                        'party' => $party,
                        'etd' => $etd,
                        'eta' => $eta,
                        'eta_wka' => $etawka,
                        'term' => $term,
                        'inv' => $inv,
                        'mu' => $mu,
                        'nilai_pib_usd' => $nilaipibusd,
                        'nilai_pib_idr' => $nilaipibidr,
                        'bm' => $bm,
                        'bmt_bmad_bmi_bmtp' => $bmtbmadbmibmpt,
                        'ppn' => $ppn,
                        'pph' => $pph,
                        'remark' => $remark,
                        'bm_dibebaskan' => $bmdibebaskan,
                        'ppn_tidakdipungut' => $ppntidakdipungut,
                        'total_payment_pib' => $totalpaymentpib,
                        'user' => user()->username
                    ];


                    $save = $this->import->insert($dataimport);

                    if ($save) {
                        $msg = [
                            'success' => 'berhasil',
                        ];
                    } else {
                        $msg = [
                            'error' => 'data masuk semua error',
                            'dataimport' => $dataimport,
                            'save' => $save
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
        // redirect()->route('exim/importbahanbaku');
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

    public function Deleteimport()
    {
        helper('form');
        if ($this->request->isAJAX()) {

            $seq = htmlspecialchars($this->request->getPost('seq'));

            if ($seq) {
                $delete = $this->import->delete($seq);
            }

            if ($delete) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }


            echo json_encode($msg);
        }
    }

    public function Datatablesimport()
    {

        $tgldari = $this->request->getPost('tgldari');
        $tglke = $this->request->getPost('tglke');
        $totalkgm = 0;

        $datafilter = [
            'tgldari' => $tgldari,
            'tglke' => $tglke,
        ];

        $request = Services::request();
        $isi = new Import_model($request);
        if ($request->getMethod(true) == "POST") {
            $isiex = $isi->get_datatablesimport($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($isiex as $ie) {
                $no++;
                $row = [];
                $row[] = 'BC 2.0';
                $row[] = $ie->tglbapb;
                $row[] =  $ie->noaju;
                $row[] = $ie->pib;
                $row[] = $ie->tglpib;
                $row[] = '1';
                $row[] = $ie->hscode;
                $row[] = $ie->bapb;
                $row[] = $ie->tglbapb;
                $row[] = $ie->kode_item;
                $row[] = $ie->itm;
                $row[] = $ie->nama_item;
                $row[] = $ie->desk;
                $row[] = $ie->satuan;
                $row[] = number_format($ie->qty, 2, ',', '.');
                $row[] = number_format($ie->kgm, 2, ',', '.');
                $row[] = 'USD';
                $row[] = number_format($ie->nilai, 2, ',', '.');
                $row[] = 'GDBSTK';
                $row[] = '0';
                $row[] = '';
                $row[] = $ie->ven_loc_country;
                $row[] = "<a class=\"btn-danger btn-delete text-xs btn-xs\" data-seq=\"$ie->seq\"><i class=\"fas fa-trash\"></i></a><a class=\"btn-success btn-edit text-xs btn-xs\" data-seq=\"$ie->seq\"><i class=\"fas fa-edit\"></i></a> <a class=\"btn-primary btn-editi text-xs btn-xs\" data-seq=\"$ie->seq\"><i class=\"fas fa-edit\"></i> Item</a>";
                $totalkgm = $totalkgm + floatval($ie->kgm);
                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $isi->count_allimport(),
                "recordsFiltered" => $isi->count_filteredimport($datafilter),
                "rendered" => $rendered,
                "totalkgm" => number_format($totalkgm, 2),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Datatablesimportjkt()
    {

        $tgldari = $this->request->getPost('tgldari');
        $tglke = $this->request->getPost('tglke');
        $totalkgm = 0;

        $datafilter = [
            'tgldari' => $tgldari,
            'tglke' => $tglke,
        ];

        $request = Services::request();
        $isi = new Import_model($request);
        if ($request->getMethod(true) == "POST") {
            $isiex = $isi->get_datatablesimportjkt($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($isiex as $ie) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $ie->aju;
                $row[] = $ie->pengirim;
                $row[] = $ie->HSCODE;
                $row[] = $ie->penjual;
                $row[] = $ie->pib;
                $row[] = $ie->tglpib;
                $row[] = $ie->kgm;
                $row[] = $ie->desk;
                $row[] = $ie->no_coo;
                $row[] = $ie->tgl_coo;
                $row[] = $ie->emkl_ptj;
                $row[] = $ie->bl;
                $row[] = $ie->negara;
                $row[] = $ie->party;
                $row[] = $ie->etd;
                $row[] = $ie->eta;
                $row[] = $ie->eta_wka;
                $row[] = $ie->fasilitas;
                $row[] = $ie->term;
                $row[] = $ie->inv;
                $row[] = $ie->MU;
                $row[] = $ie->nilai_pib_usd;
                $row[] = $ie->nilai_pib_idr;
                $row[] = $ie->bm;
                $row[] = $ie->bmt_bmad_bmi_bmtp;
                $row[] = $ie->ppn;
                $row[] = $ie->pph;
                $row[] = $ie->remark;
                $row[] = $ie->bm_dibebaskan;
                $row[] = $ie->ppn_tidakdipungut;
                $row[] = '';
                $row[] = $ie->total_payment_pib;
                $totalkgm = $totalkgm + floatval($ie->kgm);
                $row[] = "<a class=\"btn-danger btn-deletejkt text-xs btn-xs\" data-seq=\"$ie->seq\"><i class=\"fas fa-trash\"></i></a> <a class=\"btn-danger btn-edit text-xs btn-xs\" data-seq=\"$ie->seq\"><i class=\"fas fa-edit\"></i></a>";
                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $isi->count_allimportjkt(),
                "recordsFiltered" => $isi->count_filteredimportjkt($datafilter),
                "totalkgm" => number_format($totalkgm, 2),
                "rendered" => $rendered,
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}