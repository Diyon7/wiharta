<?php

namespace App\Models\potong\item;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Tipe_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'potong_mtipe_new';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'kodetipe', 'namatipe', 'jenis', 'created_at', 'updated_at', 'user'];

    protected $request;
    protected $dt;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('potong_mtipe_new');
        $this->request = $request;
    }

    public function _get_datatables_querytipe()
    {
        $column_order = array("seq", 'namatipe', 'updated_at');
        $column_search = array("seq", 'namatipe', 'updated_at');
        $order = array('namatipe' => 'asc');

        $this->dt->select("seq,kodetipe,namatipe,jenis,updated_at");

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

    public function get_datatablestipe()
    {
        $this->_get_datatables_querytipe();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredtipe()
    {
        $this->_get_datatables_querytipe();
        return $this->dt->countAllResults();
    }

    public function count_alltipe()
    {
        return $this->select("seq")
            ->countAllResults();
    }
}