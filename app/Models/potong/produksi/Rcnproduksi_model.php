<?php

namespace App\Models\potong\produksi;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Rcnproduksi_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'potong_rcn_ra';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'norcn', 'idtipe', 'vendor', 'grup', 'qty', 'tgl', 'created_at', 'updated_at', 'user'];

    protected $request;
    protected $dt;
    protected $dtri;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('potong_rcn_ra');
        $this->dtri = $this->db->table('potong_rcn_ri');
        $this->request = $request;
    }

    public function _get_datatables_querydetailrencana($data)
    {
        $column_order = array("potong_rcn.spp", "potong_rcn.spp", "potong_mtipe_new.namatipe", "potong_rcn_ra.tgl", "potong_rcn_ra.qty", "potong_rcn_ra.tgl",);
        $column_search = array("potong_rcn.spp", "potong_rcn.spp", "potong_mtipe_new.namatipe", "potong_rcn_ra.tgl", "potong_rcn_ra.qty", "potong_rcn_ra.tgl",);
        $order = array('potong_mtipe_new.`kodetipe`' => 'asc');

        $this->dt->select("potong_rcn_ra.seq,potong_rcn.spp,potong_mtipe_new.namatipe,potong_rcn_ra.tgl,potong_rcn_ra.qty");
        $this->dt->join('potong_rcn', 'potong_rcn.`norcn`=potong_rcn_ra.`norcn`');
        $this->dt->join('potong_mtipe_new', 'potong_mtipe_new.`kodetipe`=potong_rcn_ra.`idtipe`');
        $this->dt->where('potong_rcn_ra.norcn', $data['norcn']);

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

    public function get_datatablesdetailrencana($data)
    {
        $this->_get_datatables_querydetailrencana($data);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filtereddetailrencana($data)
    {
        $this->_get_datatables_querydetailrencana($data);
        return $this->dt->countAllResults();
    }

    public function count_alldetailrencana()
    {
        return $this->select("potong_rcn_ra.qty")
            ->join('potong_mtipe_new', 'potong_mtipe_new.`kodetipe`=potong_rcn_ra.`idtipe`')
            ->countAllResults();
    }

    public function _get_datatables_querydetailkumrencana($data)
    {
        $column_order = array("potong_rcn_ri.`seq`", "potong_mtipe_dtl_new.`namaitem`", "((potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)-(jra.`qty`*potong_mtipe_dtl_new.`jml`))", "(jra.`qty`*potong_mtipe_dtl_new.`jml`)", "SUM(potong_rcn_ra.`qty`)", "potong_mtipe_dtl_new.jml", "(potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)");
        $column_search = array("potong_rcn_ri.`seq`", "potong_mtipe_dtl_new.`namaitem`", "((potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)-(jra.`qty`*potong_mtipe_dtl_new.`jml`))", "(jra.`qty`*potong_mtipe_dtl_new.`jml`)", "SUM(potong_rcn_ra.`qty`)", "potong_mtipe_dtl_new.jml", "(potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)");
        $order = array('potong_mtipe_dtl_new.`namaitem`' => 'asc');

        $this->dtri->select("potong_rcn_ri.`seq`,potong_mtipe_dtl_new.`namaitem`,((potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)-(jra.`qty`*potong_mtipe_dtl_new.`jml`)) AS balancera,(jra.`qty`*potong_mtipe_dtl_new.`jml`) AS ra,potong_mtipe_dtl_new.jml AS usespp,(potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`) AS kebutuhan");
        $this->dtri->join('potong_rcn', 'potong_rcn.`norcn`=potong_rcn_ri.`norcn`');
        $this->dtri->join('potong_mtipe_dtl_new', 'potong_mtipe_dtl_new.`kodetipe`=potong_rcn.`idtipe` AND potong_mtipe_dtl_new.`kodeitem`=potong_rcn_ri.`iditem`');
        $this->dtri->join("(SELECT SUM(IFNULL(potong_rcn_ra.`qty`,0)) AS qty,norcn FROM potong_rcn_ra WHERE norcn='" . $data['norcn'] . "' GROUP BY norcn) AS jra", "jra.`norcn`=potong_rcn.`norcn`", "left");
        $this->dtri->where('potong_rcn.`norcn`', $data['norcn']);

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dtri->groupStart();
                    $this->dtri->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dtri->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->dtri->groupEnd();
            }
            $i++;
        }

        $this->dtri->groupBy('potong_rcn_ri.`iditem`');

        if ($this->request->getPost('order')) {
            $this->dtri->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->dtri->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesdetailkumrencana($data)
    {
        $this->_get_datatables_querydetailkumrencana($data);
        if ($this->request->getPost('length') != -1)
            $this->dtri->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dtri->get();
        return $query->getResult();
    }

    public function count_filtereddetailkumrencana($data)
    {
        $this->_get_datatables_querydetailkumrencana($data);
        return $this->dtri->countAllResults();
    }

    public function count_alldetailkumrencana($data)
    {
        return $this->dtri->select("potong_rcn_ri.`seq`")
            ->join('potong_rcn', 'potong_rcn.`norcn`=potong_rcn_ri.`norcn`')
            ->join('potong_mtipe_dtl_new', 'potong_mtipe_dtl_new.`kodetipe`=potong_rcn.`idtipe` AND potong_mtipe_dtl_new.`kodeitem`=potong_rcn_ri.`iditem`')
            ->where('potong_rcn.`norcn`', $data['norcn'])
            ->groupBy('potong_rcn_ri.`iditem`')
            ->countAllResults();
    }
}