<?php

namespace App\Models\exim;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Useritv_model extends Model
{
    protected $DBGroup = 'thirddb';
    protected $table      = 'log_login';
    // protected $primaryKey = 'sec';

    protected $allowedFields = ['id', 'user', 'datetime', 'ipaddress', 'sistem_operasi'];

    protected $request;
    protected $dt;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('thirddb');
        $this->dt = $this->db->table('log_login');
        $this->request = $request;
    }

    public function Countuserbc()
    {
        return $this->db->query("SELECT COUNT(USER) AS user FROM log_login WHERE USER='beacukai'")
            ->getRowArray();
    }

    public function Maxuserbc()
    {
        return $this->db->query("SELECT max(datetime) AS datetime FROM log_login WHERE USER='beacukai'")
            ->getRowArray();
    }

    public function _get_datatables_queryuseritv()
    {
        $column_order = array('id', 'user', 'datetime', 'ipaddress', 'sistem_operasi');
        $column_search = array('id', 'user', 'datetime', 'ipaddress', 'sistem_operasi');
        $order = array('datetime' => 'desc');

        $this->dt->select("user,datetime,ipaddress,sistem_operasi");

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

    public function get_datatablesuseritv()
    {
        $this->_get_datatables_queryuseritv();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filtereduseritv()
    {
        $this->_get_datatables_queryuseritv();
        return $this->dt->countAllResults();
    }

    public function count_alluseritv()
    {
        return $this->dt->select("id")
            ->countAllResults();
    }
}
