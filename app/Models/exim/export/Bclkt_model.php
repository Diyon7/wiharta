<?php

namespace App\Models\exim\export;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Bclkt_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'beacukai_export';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'qty', 'kgm', 'peb', 'tglpeb', 'inv', 'tglinv', 'aju', 'kode_item', 'customer', 'negara', 'sj', 'tglsj', 'nilai', 'bclkt', 'created_at', 'updated_at', 'user_id', 'qtyln', 'userid_deleted', 'deleted_at'];

    protected $request;
    protected $dt;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('beacukai_export');
        $this->request = $request;
    }

    public function Caribelumlaporbclkt()
    {
        return $this->db->query("SELECT peb,tglpeb FROM beacukai_export WHERE (bclkt IS NULL OR bclkt='b') GROUP BY peb")
            ->getResultArray();
    }

    public function _get_datatables_querybclkt()
    {
        $column_order = array('beacukai_export.peb', 'beacukai_export.tglpeb', 'jbclkt', 'beacukai_export.updated_at',  'beacukai_export.updated_at');
        $column_search = array('beacukai_export.peb', 'beacukai_export.tglpeb', 'jbclkt', 'beacukai_export.updated_at',  'beacukai_export.updated_at');
        $order = array('jbclkt' => 'desc');

        $this->select("beacukai_export.seq,IFNULL(jbclkt,0) AS jbclkt,beacukai_export.peb,tglpeb,beacukai_export.updated_at");
        $this->join("(SELECT COUNT(seq) AS jbclkt,peb FROM beacukai_export WHERE (bclkt IS NULL OR bclkt='b') GROUP BY peb) AS b", "b.peb=beacukai_export.`peb`", "left");
        $this->where("bclkt", "s");
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

        $this->groupBy('peb');

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesbclkt()
    {
        $this->_get_datatables_querybclkt();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredbclkt()
    {
        $this->_get_datatables_querybclkt();
        return $this->countAllResults();
    }

    public function count_allbclkt()
    {
        return $this->select("beacukai_export.seq,peb,tglpeb,updated_at")
            ->where("bclkt", "s")
            ->groupBy('peb')
            ->countAllResults();
    }
}