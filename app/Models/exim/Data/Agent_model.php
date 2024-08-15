<?php

namespace App\Models\exim\Data;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Agent_model extends Model
{
    protected $DBGroup = 'thirddb';
    protected $table      = 'm_agen';
    // protected $primaryKey = 'sec';

    protected $allowedFields = ['kode', 'nama', 'nama_pendek', 'alamat', 'kota', 'tlp', 'fax', 'attn', 'tipe'];

    protected $request;
    protected $dt;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('thirddb');
        $this->dt = $this->db->table('m_agen');
        $this->request = $request;
    }

    public function _get_datatables_queryagen()
    {
        $column_order = array('kode', 'nama', 'nama_pendek', 'alamat', 'kota', 'tlp', 'fax', 'attn', 'tipe', 'tipe');
        $column_search = array('kode', 'nama', 'nama_pendek', 'alamat', 'kota', 'tlp', 'fax', 'attn', 'tipe', 'tipe');
        $order = array('nama' => 'asc');

        $this->dt->select("kode,nama,nama_pendek,alamat,kota,tlp,fax,attn,tipe");

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

    public function get_datatablesagen()
    {
        $this->_get_datatables_queryagen();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredagen()
    {
        $this->_get_datatables_queryagen();
        return $this->dt->countAllResults();
    }

    public function count_allagen()
    {
        return $this->dt->select("kode,nama,nama_pendek,alamat,kota,tlp,fax,attn,tipe")
            ->countAllResults();
    }
}