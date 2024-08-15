<?php

namespace App\Controllers\potong;

use App\Controllers\BaseController;
use App\Models\potong\item\Item_model;
use App\Models\potong\item\Tipe_model;
use App\Models\potong\item\Tipedtl_model;
use Config\Services;
use CodeIgniter\I18n\Time;
use DateTime;

use function PHPUnit\Framework\isNull;

class Item extends BaseController
{

    protected $item;
    protected $tipe;
    protected $tipedtl;

    public function __construct()
    {
        $this->item = new Item_model();
        $this->tipe = new Tipe_model();
        $this->tipedtl = new Tipedtl_model();
    }

    public function Index()
    {

        $semuatipe = $this->tipe->findAll();
        $semuaitem = $this->item->findAll();

        $data = [
            'tipe' => $semuatipe,
            'item' => $semuaitem,
            'title' => 'WKA INFORMATION SYSTEM',
            'devisi' => 'Karyawan',
            'halaman' => 'Item Potong',
        ];

        return view('potong/item/index', $data);
    }

    public function Tambahtipedtl()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $rules = [
                    'tipe' => [
                        'label'  => 'tipe',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Tanggal harus Diisi !',
                        ],
                    ],
                ];

                if ($this->validate($rules)) {
                    $tipe = $this->request->getPost('tipe');
                    $item = $this->request->getPost('item');
                    $use = $this->request->getPost('use');

                    $dtipe = $this->tipe->where('kodetipe', $tipe)->find();
                    $ditem = $this->item->where('kodeitem', $item)->find();

                    $data = [
                        'kodetipe' => $tipe,
                        'namatipe' => $dtipe[0]['namatipe'],
                        'kodeitem' => $item,
                        'namaitem' => $ditem[0]["namaitem"],
                        'jml' => $use
                    ];

                    $save = $this->tipedtl->Addtipedtl($data);
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

    public function Tambahtipe()
    {
        if ($this->request->isAJAX()) {
            // if ($this->request->getMethod() == 'post') {

            $rules = [
                'namatipe' => [
                    'label'  => 'namatipe',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Namatipe harus Diisi !',
                    ],
                ],
            ];

            if ($this->validate($rules)) {
                $namatipe = $this->request->getPost('namatipe');

                $maxkode = $this->tipe->selectMax('kodetipe')->first();

                $maxkode2 = $maxkode['kodetipe'] + 1;

                $data = [
                    'kodetipe' => $maxkode2,
                    'namatipe' => $namatipe,
                ];

                $save = $this->tipe->save($data);

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
            // }
            echo json_encode($msg);
        }
    }

    public function Tambahitem()
    {
        if ($this->request->isAJAX()) {
            // if ($this->request->getMethod() == 'post') {

            $rules = [
                'namaitem' => [
                    'label'  => 'namaitem',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Namaitem harus Diisi !',
                    ],
                ],
            ];

            if ($this->validate($rules)) {
                $namaitem = $this->request->getPost('namaitem');

                $maxkode = $this->item->selectMax('kodeitem')->first();

                $maxkode2 = $maxkode['kodeitem'] + 1;

                $data = [
                    'kodeitem' => $maxkode2,
                    'namaitem' => $namaitem,
                ];

                $save = $this->item->save($data);

                if ($save) {
                    $msg = [
                        'success' => $maxkode,
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
            // }
            echo json_encode($msg);
        }
    }

    public function Tipeitemedit()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $item = $this->item->findAll();
            $tipeitem = $this->tipedtl->where('seq', $id)->find();



            $data = [
                'item' => $item,
                'tipeitem' => $tipeitem

            ];
            $msg = [
                'sukses' => view('potong/item/edit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Tipeedit()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $alltipe = $this->tipe->findAll();
            $tipe = $this->tipe->where('seq', $id)->find();

            $data = [
                'alltipe' => $alltipe,
                'tipe' => $tipe

            ];
            $msg = [
                'sukses' => view('potong/item/tipeedit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function Savetipeitem()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $seque = $this->request->getPost('seq');
                $tipe = htmlspecialchars($this->request->getPost('tipe'));
                $item = htmlspecialchars($this->request->getPost('item'));
                $use = htmlspecialchars($this->request->getPost('use'));

                $dtipe = $this->tipe->where('kodetipe', $tipe)->find();
                $ditem = $this->item->where('kodeitem', $item)->find();
                $tipeitem = $this->tipedtl->where('seq', $seque)->first();

                $namaitem = $ditem[0]["namaitem"];



                $dtla = [
                    'kodeitem' => $item,
                    'use' => $use,
                    'namaitem' => $namaitem,
                    'seque' => $seque
                ];

                $dtlari = [
                    'tipe' => $tipe,
                    'item' => $item,
                    'kodetipeitem' => $tipeitem['kodeitem']
                ];

                $dataupdate = $this->tipedtl->Updadata($dtla);
                $dataupdate = $this->tipedtl->Updadatari($dtlari);

                $msg = [
                    'success' => $dtla,
                    "seq" => $dataupdate
                ];
                // if ($dataupdate) {
                //     session()->setFlashdata('success', 'Edit data berhasil');
                // } else {
                //     $msg = [
                //         'error' => 'data error'
                //     ];
                // }

                echo json_encode($msg);
            }
        }
    }

    public function Savetipe()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {

                $seque = $this->request->getPost('seq');
                $kodetipe = htmlspecialchars($this->request->getPost('kodetipe'));
                $namatipe = htmlspecialchars($this->request->getPost('namatipe'));

                $dtla = [
                    'namatipe' => $namatipe,
                ];

                $dataupdate = $this->tipe->where('kodetipe', $kodetipe)->set($dtla)->update();
                $dataupdate = $this->tipedtl->where('kodetipe', $kodetipe)->set($dtla)->update();

                $msg = [
                    'success' => $dtla,
                    "seq" => $dataupdate
                ];

                echo json_encode($msg);
            }
        }
    }

    public function Datatablestipeitem()
    {

        $kodetipe = $this->request->getPost('tipe');

        $totalqty = 0;
        $totalkgm = 0;

        $datafilter = [
            'kodetipe' => $kodetipe,
        ];

        $request = Services::request();
        $mutasiproduksi2 = new Tipedtl_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $mutasiproduksi2->get_datatablestipeitem($datafilter);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->namatipe;
                $row[] = $gs->namaitem;
                $row[] = $gs->jml;
                $row[] = "<a class=\"btn-danger btn-edit text-xs btn-xs\" data-seq=\"$gs->seq\"><i class=\"fas fa-edit\"></i></a>";
                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $mutasiproduksi2->count_alltipeitem(),
                "recordsFiltered" => $mutasiproduksi2->count_filteredtipeitem($datafilter),
                "rendered" => $rendered,
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Datatablestipe()
    {
        $totalqty = 0;
        $totalkgm = 0;


        $request = Services::request();
        $tipe = new Tipe_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $tipe->get_datatablestipe();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->namatipe;
                $row[] = "<a class=\"btn-danger btn-edit text-xs btn-xs\" data-seq=\"$gs->seq\"><i class=\"fas fa-edit\"></i></a>";
                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $tipe->count_alltipe(),
                "recordsFiltered" => $tipe->count_filteredtipe(),
                "rendered" => $rendered,
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function Datatablesitem()
    {

        $request = Services::request();
        $item = new Item_model($request);
        if ($request->getMethod(true) == "POST") {
            $lists = $item->get_datatablesitem();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $gs) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $gs->namaitem;
                $row[] = "IT Support";
                // $row[] = "<a class=\"btn-danger btn-edit text-xs btn-xs\" data-seq=\"$gs->seq\"><i class=\"fas fa-edit\"></i></a>";
                $data[] = $row;
            }
            $rendered = "<p>Page rendered in {elapsed_time} Second</p>";
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $item->count_allitem(),
                "recordsFiltered" => $item->count_filtereditem(),
                "rendered" => $rendered,
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
}