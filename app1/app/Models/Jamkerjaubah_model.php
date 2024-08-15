<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Jamkerjaubah_model extends Model
{
    protected $table      = 'ganti_jk_pegawai';
    protected $primaryKey = 'ganti_jk_id';

    protected $allowedFields = ['ganti_jk_id', 'pegawai_id', 'tgl_awal', 'tgl_akhir', 'jk_id', 'keterangan', 'verifikasi', 'namauser'];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;

    protected $request;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function _get_datatables_queryjamkerja()
    {
        $column_order = array('pegawai.pegawai_nama', 'jam_kerja.jk_name', 'tgl_awal', 'tgl_akhir', 'keterangan', 'verifikasi');
        $column_search = array('pegawai.pegawai_nama', 'jam_kerja.jk_name', 'tgl_awal', 'tgl_akhir', 'keterangan', 'verifikasi');
        $order = array('created_at' => 'desc');

        $this->select("ganti_jk_id, pegawai.pegawai_nama AS nama, ganti_jk_pegawai.pegawai_id as pegawai_id, jam_kerja.jk_name as shift, tgl_awal, tgl_akhir, keterangan, verifikasi");
        $this->join('pegawai', 'pegawai.pegawai_nip=ganti_jk_pegawai.pegawai_id');
        $this->join('jam_kerja', 'jam_kerja.jk_id=ganti_jk_pegawai.jk_id');

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesjamkerja()
    {
        $this->_get_datatables_queryjamkerja();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredjamkerja()
    {
        $this->_get_datatables_queryjamkerja();
        return $this->countAllResults();
    }

    public function count_alljamkerja()
    {
        $this->select("tgl_awal, tgl_akhir, keterangan, verifikasi");
        return $this->countAllResults();
    }
    
    public function Alldata() {
        return $this->select("pegawai.pegawai_nama AS nama, jamkerja.jk_name as shift, tgl_awal, tgl_akhir, keterangan, verifikasi")
                ->join('pegawai', 'pegawai.pegawai_nip=ganti_jk_pegawai.pegawai_id')
                ->join('jam_kerja', 'jam_kerja.jk_id=ganti_jk_pegawai.jk_id')
                ->get()->getResultArray();
    }
    
    public function _get_datatables_queryjamkerjaljp3()
    {
        $column_order = array('pegawai.pegawai_nama', 'jam_kerja.jk_name', 'tgl_awal', 'tgl_akhir', 'keterangan', 'verifikasi');
        $column_search = array('pegawai.pegawai_nama', 'jam_kerja.jk_name', 'tgl_awal', 'tgl_akhir', 'keterangan', 'verifikasi');
        $order = array('created_at' => 'desc');

        $this->select("ganti_jk_id, pegawai.pegawai_nama AS nama, ganti_jk_pegawai.pegawai_id as pegawai_id, jam_kerja.jk_name as shift, tgl_awal, tgl_akhir, keterangan, verifikasi");
        $this->join('pegawai', 'pegawai.pegawai_nip=ganti_jk_pegawai.pegawai_id');
        $this->join('jam_kerja', 'jam_kerja.jk_id=ganti_jk_pegawai.jk_id');
        $this->where('verifikasi', 's');

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablespjamkerja()
    {
        $this->_get_datatables_queryjamkerjaljp3();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredpjamkerja()
    {
        $this->_get_datatables_queryjamkerjaljp3();
        return $this->countAllResults();
    }
    public function count_allpjamkerja()
    {
       $this->select("ganti_jk_id, pegawai.pegawai_nama AS nama, ganti_jk_pegawai.pegawai_id as pegawai_id, jam_kerja.jk_name as shift, tgl_awal, tgl_akhir, keterangan, verifikasi");
        $this->join('pegawai', 'pegawai.pegawai_nip=ganti_jk_pegawai.pegawai_id');
        $this->join('jam_kerja', 'jam_kerja.jk_id=ganti_jk_pegawai.jk_id');
        $this->where('verifikasi', 's');
        return $this->countAllResults();
    }

    public function _get_datatables_queryjamkerjab()
    {
        $column_order = array('pegawai.pegawai_nama', 'jam_kerja.jk_name', 'tgl_awal', 'tgl_akhir', 'keterangan', 'verifikasi');
        $column_search = array('pegawai.pegawai_nama', 'jam_kerja.jk_name', 'tgl_awal', 'tgl_akhir', 'keterangan', 'verifikasi');
        $order = array('created_at' => 'desc');

        $this->select("ganti_jk_id, pegawai.pegawai_nama AS nama, ganti_jk_pegawai.pegawai_id as pegawai_id, jam_kerja.jk_name as shift, tgl_awal, tgl_akhir, keterangan, verifikasi");
        $this->join('pegawai', 'pegawai.pegawai_nip=ganti_jk_pegawai.pegawai_id');
        $this->join('jam_kerja', 'jam_kerja.jk_id=ganti_jk_pegawai.jk_id');
        $this->where('verifikasi', 'p');

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesjamkerjab()
    {
        $this->_get_datatables_queryjamkerjab();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredpjamkerjab()
    {
        $this->_get_datatables_queryjamkerjab();
        return $this->countAllResults();
    }

    public function count_alljamkerjab()
    {
        $this->select("ganti_jk_id, pegawai.pegawai_nama AS nama, ganti_jk_pegawai.pegawai_id as pegawai_id, jam_kerja.jk_name as shift, tgl_awal, tgl_akhir, keterangan, verifikasi");
        $this->join('pegawai', 'pegawai.pegawai_nip=ganti_jk_pegawai.pegawai_id');
        $this->join('jam_kerja', 'jam_kerja.jk_id=ganti_jk_pegawai.jk_id');
        $this->where('verifikasi', 'p');
    }

    public function _get_datatables_queryjamkerjac()
    {
       $column_order = array('pegawai.pegawai_nama', 'jam_kerja.jk_name', 'tgl_awal', 'tgl_akhir', 'keterangan', 'verifikasi');
        $column_search = array('pegawai.pegawai_nama', 'jam_kerja.jk_name', 'tgl_awal', 'tgl_akhir', 'keterangan', 'verifikasi');
        $order = array('created_at' => 'desc');

        $this->select("ganti_jk_id, pegawai.pegawai_nama AS nama, ganti_jk_pegawai.pegawai_id as pegawai_id, jam_kerja.jk_name as shift, tgl_awal, tgl_akhir, keterangan, verifikasi");
        $this->join('pegawai', 'pegawai.pegawai_nip=ganti_jk_pegawai.pegawai_id');
        $this->join('jam_kerja', 'jam_kerja.jk_id=ganti_jk_pegawai.jk_id');
        $this->where('verifikasi', 't');

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesjamkerjac()
    {
        $this->_get_datatables_queryjamkerjac();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredjamkerjac()
    {
        $this->_get_datatables_queryjamkerjac();
        return $this->countAllResults();
    }

    public function count_alljamkerjac()
    {
        $this->select("ganti_jk_id, pegawai.pegawai_nama AS nama, ganti_jk_pegawai.pegawai_id as pegawai_id, jam_kerja.jk_name as shift, tgl_awal, tgl_akhir, keterangan, verifikasi");
        $this->join('pegawai', 'pegawai.pegawai_nip=ganti_jk_pegawai.pegawai_id');
        $this->join('jam_kerja', 'jam_kerja.jk_id=ganti_jk_pegawai.jk_id');
        $this->where('verifikasi', 't');
        return $this->countAllResults();
    }
}
