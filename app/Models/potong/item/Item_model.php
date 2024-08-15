<?php

namespace App\Models\potong\item;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Item_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'potong_mitem_new';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'kodeitem', 'namaitem', 'warna', 'jenis', 'kode', 'panjang', 'lebar', 'created_at', 'updated_at'];

    protected $request;
    protected $dt;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('potong_mitem_new');
        $this->request = $request;
    }

    public function _get_datatables_queryitem()
    {
        $column_order = array("seq", 'namaitem', 'updated_at');
        $column_search = array("seq", 'namaitem', 'updated_at');
        $order = array('namaitem' => 'asc');

        $this->dt->select("seq,kodeitem,namaitem");

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

    public function get_datatablesitem()
    {
        $this->_get_datatables_queryitem();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filtereditem()
    {
        $this->_get_datatables_queryitem();
        return $this->dt->countAllResults();
    }

    public function count_allitem()
    {
        return $this->select("seq")
            ->countAllResults();
    }
}