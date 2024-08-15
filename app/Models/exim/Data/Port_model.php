<?php

namespace App\Models\exim\Data;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Port_model extends Model
{
    protected $DBGroup = 'thirddb';
    protected $table      = 'm_port';
    // protected $primaryKey = 'sec';

    protected $allowedFields = ['kode', 'port', 'kode_port', 'm_negara_kode', 'tipe', 'nama_pendek', 'freight_no'];

    protected $request;
    protected $dt;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('thirddb');
        $this->dt = $this->db->table('m_port');
        $this->request = $request;
    }

    public function _get_datatables_queryport()
    {
        $column_order = array('kode', 'port', 'nama_pendek', 'kode_port', 'negara', 'negara');
        $column_search = array('kode', 'port', 'nama_pendek', 'kode_port', 'negara', 'negara');
        $order = array('port' => 'asc');

        $this->dt->select("m_port.`kode`,kode_port,m_negara_kode,negara,tipe,port,nama_pendek,freight_no");
        $this->dt->join('m_negara', 'm_negara.`kode`=m_port.`m_negara_kode`');

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesport()
    {
        $this->_get_datatables_queryport();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredport()
    {
        $this->_get_datatables_queryport();
        return $this->dt->countAllResults();
    }

    public function count_allport()
    {
        return $this->dt->select("m_port.`kode`,kode_port,m_negara_kode,negara,tipe,port,nama_pendek,freight_no")
            ->join('m_negara', 'm_negara.`kode`=m_port.`m_negara_kode`')
            ->countAllResults();
    }
}
