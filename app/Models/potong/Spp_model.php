<?php

namespace App\Models\potong;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Spp_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'potong_rcn';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'spp', 'norcn', 'idtipe', 'vendor', 'jml', 'tgl', 'created_at', 'updated_at'];

    protected $request;
    protected $dt;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('potong_rcn');
        $this->request = $request;
    }

    public function Codercn()
    {
        return $this->db->query("SELECT MAX(norcn) AS norcn FROM potong_rcn")
            ->getRowArray();
    }

    public function Searchrcn()
    {
        return $this->db->query("SELECT namatipe,kodeitem,namaitem,spp,tgl,norcn FROM potong_rcn 
        LEFT JOIN potong_mtipe_dtl_new ON potong_mtipe_dtl_new.kodetipe=potong_rcn.idtipe GROUP BY potong_rcn.`seq` ORDER BY tgl DESC")
            ->getResultArray();
    }

    public function _get_datatables_querytipeitem($data)
    {
        $column_order = array("potong_mitem.`kodeitem`", 'potong_mtipe.`namatipe`', 'potong_mitem.`namaitem`', 'potong_mtipe_dtl_new.jml', 'potong_mtipe.`kodetipe`');
        $column_search = array("potong_mitem.`kodeitem`", 'potong_mtipe.`namatipe`', 'potong_mitem.`namaitem`', 'potong_mtipe_dtl_new.jml', 'potong_mtipe.`kodetipe`');
        $order = array('potong_mtipe.`kodetipe`' => 'asc');

        $this->dt->select("potong_mtipe_dtl_new.`seq`,potong_mitem.`kodeitem`,potong_mitem.`namaitem`,potong_mtipe.`kodetipe`,potong_mtipe.`namatipe`,potong_mtipe_dtl_new.jml");
        $this->dt->join('potong_mtipe', 'potong_mtipe.`kodetipe`=potong_mtipe_dtl_new.`kodetipe`');
        $this->dt->join('potong_mitem', 'potong_mitem.`kodeitem`=potong_mtipe_dtl_new.`kodeitem`');

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

    public function get_datatablestipeitem($data)
    {
        $this->_get_datatables_querytipeitem($data);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredtipeitem($data)
    {
        $this->_get_datatables_querytipeitem($data);
        return $this->dt->countAllResults();
    }

    public function count_alltipeitem()
    {
        return $this->select("potong_mitem.`kodeitem`")
            ->join('potong_mtipe', 'potong_mtipe.`kodetipe`=potong_mtipe_dtl_new.`kodetipe`')
            ->join('potong_mitem', 'potong_mitem.`kodeitem`=potong_mtipe_dtl_new.`kodeitem`')
            ->countAllResults();
    }
}