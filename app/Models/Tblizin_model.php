<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Tblizin_model extends Model
{
    protected $table      = 'tbl_izin';
    protected $primaryKey = 'id_tblizin';

    protected $allowedFields = ['id_tblizin', 'pegawai_nip', 'pegawai_nama', 'tanggal', 'file_image', 'in', 'out', 'shift', 'user_id', 'izin', 'verified', 'created_at'];

    protected $skipValidation     = false;

    protected $request;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function _get_datatables_queryizinljp3()
    {
        $column_order = array('tbl_izin.`pegawai_nip`', 'tbl_izin.`pegawai_nama`', 'tbl_izin.`tanggal`', 'tbl_izin.`in`', 'tbl_izin.`out`', 'pembagian3.`pembagian3_nama`', 'tbl_izin.`izin`', 'tbl_izin.`created_at`');
        $column_search = array('tbl_izin.`pegawai_nip`', 'tbl_izin.`pegawai_nama`', 'tbl_izin.`tanggal`', 'tbl_izin.`in`', 'tbl_izin.`out`', 'pembagian3.`pembagian3_nama`', 'tbl_izin.`izin`', 'tbl_izin.`created_at`');
        $order = array('tbl_izin.`id_tblizin`' => 'desc');

        $this->select('tbl_izin.`pegawai_nip` AS nip, tbl_izin.`id_tblizin` AS idtblizin, tbl_izin.`pegawai_nama` AS nama, tbl_izin.`tanggal` AS tanggal, pembagian3.`pembagian3_nama` AS vendor, tbl_izin.`in` AS fin, tbl_izin.`out` AS fout, tbl_izin.`izin` AS izin, tbl_izin.`created_at` AS createdat')
            ->join('pegawai', 'tbl_izin.`pegawai_nip`=pegawai.`pegawai_nip`')
            ->join('pembagian3', 'pegawai.`pembagian3_id`=pembagian3.`pembagian3_id`')
            ->where('verified', 'a');

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

    public function get_datatablespizin()
    {
        $this->_get_datatables_queryizinljp3();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredpizin()
    {
        $this->_get_datatables_queryizinljp3();
        return $this->countAllResults();
    }
    public function count_allpizin()
    {
        $this->select('tbl_izin.`pegawai_nip` AS nip, tbl_izin.`id_tblizin` AS idtblizin, tbl_izin.`pegawai_nama` AS nama, tbl_izin.`tanggal` AS tanggal, pembagian3.`pembagian3_nama` AS vendor, tbl_izin.`in` AS fin, tbl_izin.`out` AS fout, tbl_izin.`izin` AS izin, tbl_izin.`created_at` AS createdat')
            ->join('pegawai', 'tbl_izin.`pegawai_nip`=pegawai.`pegawai_nip`')
            ->join('pembagian3', 'pegawai.`pembagian3_id`=pembagian3.`pembagian3_id`')
            ->where('verified', 'a');
        return $this->countAllResults();
    }

    public function _get_datatables_queryizinb()
    {
        $column_order = array('tbl_izin.`pegawai_nip`', 'tbl_izin.`pegawai_nama`', 'tbl_izin.`tanggal`', 'tbl_izin.`in`', 'tbl_izin.`out`', 'pembagian3.`pembagian3_nama`', 'tbl_izin.`izin`', 'tbl_izin.`created_at`');
        $column_search = array('tbl_izin.`pegawai_nip`', 'tbl_izin.`pegawai_nama`', 'tbl_izin.`tanggal`', 'tbl_izin.`in`', 'tbl_izin.`out`', 'pembagian3.`pembagian3_nama`', 'tbl_izin.`izin`', 'tbl_izin.`created_at`');
        $order = array('tbl_izin.`id_tblizin`' => 'desc');

        $this->select('tbl_izin.`pegawai_nip` AS nip, tbl_izin.`id_tblizin` AS idtblizin, tbl_izin.`pegawai_nama` AS nama, tbl_izin.`tanggal` AS tanggal, pembagian3.`pembagian3_nama` AS vendor, tbl_izin.`in` AS fin, tbl_izin.`out` AS fout, tbl_izin.`izin` AS izin, tbl_izin.`created_at` AS createdat')
            ->join('pegawai', 'tbl_izin.`pegawai_nip`=pegawai.`pegawai_nip`')
            ->join('pembagian3', 'pegawai.`pembagian3_id`=pembagian3.`pembagian3_id`')
            ->where('verified', 'b')
            ->where('tbl_izin.`izin`!=', '');

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

    public function get_datatablesizinb()
    {
        $this->_get_datatables_queryizinb();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredpizinb()
    {
        $this->_get_datatables_queryizinb();
        return $this->countAllResults();
    }

    public function count_allizinb()
    {
        $this->select('tbl_izin.`pegawai_nip` AS nip, tbl_izin.`id_tblizin` AS idtblizin, tbl_izin.`pegawai_nama` AS nama, tbl_izin.`tanggal` AS tanggal, pembagian3.`pembagian3_nama` AS vendor, tbl_izin.`in` AS fin, tbl_izin.`out` AS fout, tbl_izin.`izin` AS izin, tbl_izin.`created_at` AS createdat')
            ->join('pegawai', 'tbl_izin.`pegawai_nip`=pegawai.`pegawai_nip`')
            ->join('pembagian3', 'pegawai.`pembagian3_id`=pembagian3.`pembagian3_id`')
            ->where('verified', 'b');
        return $this->countAllResults();
    }

    public function _get_datatables_queryizinhb()
    {
        $column_order = array('tbl_izin.`pegawai_nip`', 'tbl_izin.`pegawai_nama`', 'tbl_izin.`tanggal`', 'tbl_izin.`in`', 'tbl_izin.`out`', 'pembagian3.`pembagian3_nama`', 'tbl_izin.`izin`', 'tbl_izin.`created_at`');
        $column_search = array('tbl_izin.`pegawai_nip`', 'tbl_izin.`pegawai_nama`', 'tbl_izin.`tanggal`', 'tbl_izin.`in`', 'tbl_izin.`out`', 'pembagian3.`pembagian3_nama`', 'tbl_izin.`izin`', 'tbl_izin.`created_at`');
        $order = array('tbl_izin.`id_tblizin`' => 'desc');

        $this->select('tbl_izin.`pegawai_nip` AS nip, tbl_izin.`id_tblizin` AS idtblizin, tbl_izin.`pegawai_nama` AS nama, tbl_izin.`tanggal` AS tanggal, pembagian3.`pembagian3_nama` AS vendor, tbl_izin.`in` AS fin, tbl_izin.`out` AS fout, tbl_izin.`izin` AS izin, tbl_izin.`created_at` AS createdat')
            ->join('pegawai', 'tbl_izin.`pegawai_nip`=pegawai.`pegawai_nip`')
            ->join('pembagian3', 'pegawai.`pembagian3_id`=pembagian3.`pembagian3_id`')
            ->where('verified', 'b')
            ->where('tbl_izin.`izin`', '');

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

    public function get_datatablesizinhb()
    {
        $this->_get_datatables_queryizinhb();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredpizinhb()
    {
        $this->_get_datatables_queryizinhb();
        return $this->countAllResults();
    }

    public function count_allizinhb()
    {
        $this->select('tbl_izin.`pegawai_nip` AS nip, tbl_izin.`id_tblizin` AS idtblizin, tbl_izin.`pegawai_nama` AS nama, tbl_izin.`tanggal` AS tanggal, pembagian3.`pembagian3_nama` AS vendor, tbl_izin.`in` AS fin, tbl_izin.`out` AS fout, tbl_izin.`izin` AS izin, tbl_izin.`created_at` AS createdat')
            ->join('pegawai', 'tbl_izin.`pegawai_nip`=pegawai.`pegawai_nip`')
            ->join('pembagian3', 'pegawai.`pembagian3_id`=pembagian3.`pembagian3_id`')
            ->where('verified', 'b')
            ->where('tbl_izin.`izin`', '');
        return $this->countAllResults();
    }

    public function _get_datatables_queryizinc()
    {
        $column_order = array('tbl_izin.`pegawai_nip`', 'tbl_izin.`pegawai_nama`', 'tbl_izin.`tanggal`', 'tbl_izin.`in`', 'tbl_izin.`out`', 'pembagian3.`pembagian3_nama`', 'tbl_izin.`izin`', 'tbl_izin.`created_at`');
        $column_search = array('tbl_izin.`pegawai_nip`', 'tbl_izin.`pegawai_nama`', 'tbl_izin.`tanggal`', 'tbl_izin.`in`', 'tbl_izin.`out`', 'pembagian3.`pembagian3_nama`', 'tbl_izin.`izin`', 'tbl_izin.`created_at`');
        $order = array('tbl_izin.`id_tblizin`' => 'desc');

        $this->select('tbl_izin.`pegawai_nip` AS nip, tbl_izin.`id_tblizin` AS idtblizin, tbl_izin.`pegawai_nama` AS nama, tbl_izin.`tanggal` AS tanggal, pembagian3.`pembagian3_nama` AS vendor, tbl_izin.`in` AS fin, tbl_izin.`out` AS fout, tbl_izin.`izin` AS izin, tbl_izin.`created_at` AS createdat')
            ->join('pegawai', 'tbl_izin.`pegawai_nip`=pegawai.`pegawai_nip`')
            ->join('pembagian3', 'pegawai.`pembagian3_id`=pembagian3.`pembagian3_id`')
            ->where('verified', 'c');

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

    public function get_datatablesizinc()
    {
        $this->_get_datatables_queryizinc();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredizinc()
    {
        $this->_get_datatables_queryizinc();
        return $this->countAllResults();
    }

    public function count_allizinc()
    {
        $this->select('tbl_izin.`pegawai_nip` AS nip, tbl_izin.`id_tblizin` AS idtblizin, tbl_izin.`pegawai_nama` AS nama, tbl_izin.`tanggal` AS tanggal, pembagian3.`pembagian3_nama` AS vendor, tbl_izin.`in` AS fin, tbl_izin.`out` AS fout, tbl_izin.`izin` AS izin, tbl_izin.`created_at` AS createdat')
            ->join('pegawai', 'tbl_izin.`pegawai_nip`=pegawai.`pegawai_nip`')
            ->join('pembagian3', 'pegawai.`pembagian3_id`=pembagian3.`pembagian3_id`')
            ->where('verified', 'c');
        return $this->countAllResults();
    }

    public function _get_datatables_querylogizin()
    {
        $column_order = array('tbl_izin.`pegawai_nip`', 'tbl_izin.`pegawai_nama`', 'tbl_izin.`tanggal`', 'tbl_izin.`in`', 'tbl_izin.`out`', 'tbl_izin.`izin`', 'tbl_izin.verified', 'tbl_izin.`created_at`');
        $column_search = array('tbl_izin.`pegawai_nip`', 'tbl_izin.`pegawai_nama`', 'tbl_izin.`tanggal`', 'tbl_izin.`in`', 'tbl_izin.`out`', 'tbl_izin.`izin`', 'tbl_izin.verified', 'tbl_izin.`created_at`');
        $order = array('tbl_izin.`updated_at`' => 'desc');

        $this->select('tbl_izin.`pegawai_nip` AS nip, tbl_izin.`id_tblizin` AS idtblizin, tbl_izin.`pegawai_nama` AS nama, tbl_izin.`tanggal` AS tanggal, tbl_izin.`in` AS fin, tbl_izin.`out` AS fout, tbl_izin.verified AS verified, tbl_izin.`izin` AS izin, tbl_izin.`created_at` AS createdat')
            ->join('pegawai', 'tbl_izin.`pegawai_nip`=pegawai.`pegawai_nip`')
            ->join('pembagian3', 'pegawai.`pembagian3_id`=pembagian3.`pembagian3_id`')
            ->like('pembagian3.`pembagian3_nama`', $this->request->getPost('vendor'));

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

    public function get_datatableslogizin()
    {
        $this->_get_datatables_querylogizin();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredlogizin()
    {
        $this->_get_datatables_querylogizin();
        return $this->countAllResults();
    }

    public function count_alllogizin()
    {
        $this->select('tbl_izin.`pegawai_nip` AS nip, tbl_izin.`id_tblizin` AS idtblizin, tbl_izin.`pegawai_nama` AS nama, tbl_izin.`tanggal` AS tanggal, tbl_izin.`in` AS fin, tbl_izin.`out` AS fout, tbl_izin.`izin` AS izin, tbl_izin.`created_at` AS createdat');
        return $this->countAllResults();
    }
}