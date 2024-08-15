<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Logkaryawan_model extends Model
{
    protected $table      = 'pegawai';
    protected $primaryKey = 'pegawai_id';

    protected $allowedFields = ['pegawai_pin', 'pegawai_nip', 'pembagian3_id', 'pegawai_id'];

    protected $useTimestamps = false;

    protected $skipValidation     = false;

    protected $request;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function _get_datatables_querykaryawanajp3()
    {
        $column_order = array('pegawai.`pegawai_nip`', 'pembagian3.`pembagian3_nama`', 'pegawai.`pegawai_nama`', 'pembagian5.`pembagian5_nama`', 'att_log.`scan_date`');
        $column_search = array('pegawai.`pegawai_nip`', 'pembagian3.`pembagian3_nama`', 'pegawai.`pegawai_nama`', 'pembagian5.`pembagian5_nama`', 'att_log.`scan_date`');
        $order = array('att_log.`scan_date`' => 'desc');

        $this->select("pegawai.`pegawai_nip` as idkar, pembagian3.`pembagian3_nama` as vendor, pegawai.`pegawai_nama` as nama, pembagian5.`pembagian5_nama` as bagian, IF(att_log.`inoutmode`=1, 'IN', IF(att_log.`inoutmode`=2, 'OUT', IF(att_log.`inoutmode`=3, 'IN', IF(att_log.`inoutmode`=4, 'OUT', IF(att_log.`inoutmode`=5, 'IN', IF(att_log.`inoutmode`=6, 'OUT', IF(att_log.`inoutmode`=7, 'IN', IF(att_log.`inoutmode`=8, 'OUT', IF(att_log.`inoutmode`=9, 'IN', 'OUT'))))))))) AS inouttype, att_log.`scan_date` AS scandate, pegawai.`grup_t` as grup_t");
        $this->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`', 'left');
        $this->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`', 'left');
        $this->join('att_log', 'att_log.`pin`=pegawai.`pegawai_pin`', 'right');
        $this->like('pembagian3.`pembagian3_nama`', $this->request->getPost('vendor'));
        $this->where('pegawai.`resign`', '0');
        // $this->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'");

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

    public function get_datatableskaryawanajp3()
    {
        $this->_get_datatables_querykaryawanajp3();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredkaryawanajp3()
    {
        $this->_get_datatables_querykaryawanajp3();
        return $this->countAllResults();
    }

    public function count_allkaryawanajp3()
    {
        $this->select('pegawai.`pegawai_nip` as idkar, pembagian3.`pembagian3_nama` as vendor, pegawai.`pegawai_nama` as nama, pembagian5.`pembagian5_nama` as bagian, pegawai.`tgl_mulai_kerja` as tmt, pegawai.`grup_t` as grup_t');
        $this->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`');
        $this->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`');
        $this->join('att_log', 'att_log.`pin`=pegawai.`pegawai_pin`', 'right');
        $this->where('pegawai.`resign`', '0');
        // $this->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'");
        return $this->countAllResults();
    }
}
