<?php

namespace App\Models\exim\Data;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Produk_model extends Model
{
    protected $DBGroup = 'thirddb';
    protected $table      = 'm_produk';
    // protected $primaryKey = 'sec';

    protected $allowedFields = ['kode', 'produk'];

    protected $request;
    protected $dt;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('thirddb');
        $this->dt = $this->db->table('m_produk');
        $this->request = $request;
    }

    public function _get_datatables_queryproduk()
    {
        $column_order = array('kode', 'produk', 'm_satuan_kode', 'hs_code');
        $column_search = array('kode', 'produk', 'm_satuan_kode', 'hs_code');
        $order = array('produk' => 'asc');

        $this->dt->select("kode,produk,m_satuan_kode,hs_code");

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

    public function get_datatablesproduk()
    {
        $this->_get_datatables_queryproduk();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredproduk()
    {
        $this->_get_datatables_queryproduk();
        return $this->dt->countAllResults();
    }

    public function count_allproduk()
    {
        return $this->dt->select("kode,produk,m_satuan_kode,hs_code")
            ->countAllResults();
    }
}
