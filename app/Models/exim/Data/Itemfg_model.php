<?php

namespace App\Models\exim\Data;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Itemfg_model extends Model
{
    protected $DBGroup = 'thirddb';
    protected $table      = 'm_item';
    protected $primaryKey = 'kode';

    protected $allowedFields = ['kode', 'idmrp', 'nama', 'm_produk_kode', 'tipe_produksi', 'tipe_customer', 'ukuran', 'size_packaging', 'color', 'm_kemasan_kode', 'default_kemasan', 'default_netto', 'default_brutto', 'hs_code_destination', 'deskripsi_tipe', 'm_satuan_kode'];

    protected $request;
    protected $dt;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('thirddb');
        $this->dt = $this->db->table('m_item');
        $this->request = $request;
    }

    public function _get_datatables_queryitemfg()
    {
        $column_order = array('kode', 'idmrp', 'nama', 'm_produk_kode', 'tipe_produksi', 'tipe_customer', 'ukuran', 'size_packaging', 'color', 'm_kemasan_kode', 'default_kemasan', 'default_netto', 'default_brutto', 'hs_code_destination', 'm_satuan_kode', 'm_satuan_kode');
        $column_search = array('kode', 'idmrp', 'nama', 'm_produk_kode', 'tipe_produksi', 'tipe_customer', 'ukuran', 'size_packaging', 'color', 'm_kemasan_kode', 'default_kemasan', 'default_netto', 'default_brutto', 'hs_code_destination', 'm_satuan_kode', 'm_satuan_kode');
        $order = array('nama' => 'asc');

        $this->dt->select("kode,idmrp,nama,m_produk_kode,tipe_produksi,tipe_customer,ukuran,size_packaging,color,m_kemasan_kode,default_kemasan,default_netto,default_brutto,hs_code_destination,m_satuan_kode");

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

    public function get_datatablesitemfg()
    {
        $this->_get_datatables_queryitemfg();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filtereditemfg()
    {
        $this->_get_datatables_queryitemfg();
        return $this->dt->countAllResults();
    }

    public function count_allitemfg()
    {
        return $this->dt->select("kode,idmrp,nama,m_produk_kode,tipe_produksi,tipe_customer,ukuran,size_packaging,color,m_kemasan_kode,default_kemasan,default_netto,default_brutto,hs_code_destination,m_satuan_kode")
            ->countAllResults();
    }
}
