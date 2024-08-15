<?php

namespace App\Models\exim\Data;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Kemasan_model extends Model
{
    protected $DBGroup = 'thirddb';
    protected $table      = 'm_kemasan';
    // protected $primaryKey = 'sec';

    protected $allowedFields = ['kode', 'satuan', 'satuan_besar'];

    protected $request;
    protected $dt;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('thirddb');
        $this->dt = $this->db->table('m_kemasan');
        $this->request = $request;
    }

    public function _get_datatables_querykemasan()
    {
        $column_order = array('kode', 'satuan', 'satuan_besar');
        $column_search = array('kode', 'satuan', 'satuan_besar');
        $order = array('satuan' => 'asc');

        $this->dt->select("kode,satuan,satuan_besar");

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

    public function get_datatableskemasan()
    {
        $this->_get_datatables_querykemasan();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredkemasan()
    {
        $this->_get_datatables_querykemasan();
        return $this->dt->countAllResults();
    }

    public function count_allkemasan()
    {
        return $this->dt->select("kode,satuan,satuan_besar")
            ->countAllResults();
    }
}
