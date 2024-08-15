<?php

namespace App\Models\potong\produksi;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Prosesproduksi_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'potong_rcn_ri';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'iditem', 'tgl', 'jenis', 'jenismesin', 'norcn', 'no', 'qty', 'kgm', 'shift', 'grup', 'vendor', 'created_at', 'updated_at', 'user', 'user_update'];

    protected $request;
    protected $dt;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('potong_rcn_ri');
        $this->request = $request;
    }

    public function Searchtipercn($data)
    {
        return $this->db->query("SELECT kodeitem,namaitem FROM potong_rcn 
        LEFT JOIN potong_mtipe_dtl_new ON potong_mtipe_dtl_new.kodetipe=potong_rcn.idtipe WHERE potong_rcn.norcn='$data'")
            ->getResultArray();
    }
    public function Finddata($data)
    {
        return $this->db->query("select potong_rcn_ri.`seq`,potong_rcn_ri.`tgl`,potong_rcn_ri.`jenismesin`,potong_rcn_ri.`no`,potong_rcn_ri.`qty`,potong_rcn_ri.`kgm`,potong_rcn_ri.`grup`,potong_rcn_ri.`vendor`,potong_mtipe_dtl_new.`kodeitem`,potong_mtipe_dtl_new.`namaitem`,potong_mtipe_dtl_new.`kodetipe` from potong_rcn_ri
join potong_rcn on potong_rcn.`norcn`=potong_rcn_ri.`norcn`
join potong_mtipe_dtl_new on potong_mtipe_dtl_new.`kodetipe`=potong_rcn.`idtipe` and potong_mtipe_dtl_new.`kodeitem`=potong_rcn_ri.`iditem` where potong_rcn_ri.`seq`='$data' group by potong_rcn_ri.`seq`")
            ->getRowArray();
    }

    public function _get_datatables_querydetailrealisasi($data)
    {
        $column_order = array("potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`jml`", "potong_rcn_ri.`tgl`", "potong_rcn_ri.`qty`", "potong_rcn_ri.`kgm`", "potong_rcn_ri.`grup`", "potong_rcn_ri.`vendor`", "jenismesin", "jenismesin");
        $column_search = array("potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`jml`", "potong_rcn_ri.`tgl`", "potong_rcn_ri.`qty`", "potong_rcn_ri.`kgm`", "potong_rcn_ri.`grup`", "potong_rcn_ri.`vendor`", "jenismesin", "jenismesin");
        $order = array('potong_rcn_ri.`tgl`' => 'asc');

        $this->dt->select("potong_rcn_ri.`seq`,potong_mtipe_dtl_new.`namaitem`,potong_mtipe_dtl_new.jml as usespp,potong_mtipe_dtl_new.`kodeitem`,potong_rcn_ri.`tgl`,jenismesin,potong_rcn_ri.`norcn`,potong_rcn_ri.`no`,potong_rcn_ri.`qty`,potong_rcn_ri.`grup`,potong_rcn_ri.`kgm`,potong_rcn_ri.`vendor`");
        $this->dt->join('potong_rcn', 'potong_rcn.`norcn`=potong_rcn_ri.`norcn`');
        $this->dt->join('potong_mtipe_dtl_new', 'potong_mtipe_dtl_new.`kodetipe`=potong_rcn.`idtipe` AND potong_mtipe_dtl_new.`kodeitem`=potong_rcn_ri.`iditem`');
        $this->dt->where('potong_rcn_ri.`norcn`', $data['norcn']);
        $this->dt->where("potong_rcn_ri.`iditem` LIKE '" . $data['cariitem'] . "'");
        $this->dt->like('potong_rcn_ri.`vendor`', $data['carivendor']);
        $this->dt->like('potong_rcn_ri.`grup`', $data['carigrup']);
        if ($data['tgldarir'] != '') {
            $this->dt->where('potong_rcn_ri.`tgl`>=', $data['tgldarir']);
        }
        if ($data['tglker'] != '') {
            $this->dt->where('potong_rcn_ri.`tgl`<=', $data['tglker']);
        }

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

        $this->dt->groupBy('potong_rcn_ri.`seq`');

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesdetailrealisasi($data)
    {
        $this->_get_datatables_querydetailrealisasi($data);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filtereddetailrealisasi($data)
    {
        $this->_get_datatables_querydetailrealisasi($data);
        return $this->dt->countAllResults();
    }

    public function count_alldetailrealisasi($data)
    {
        return $this->select("potong_rcn_ri.`seq`")
            ->join('potong_rcn', 'potong_rcn.`norcn`=potong_rcn_ri.`norcn`')
            ->join('potong_mtipe_dtl_new', 'potong_mtipe_dtl_new.`kodetipe`=potong_rcn.`idtipe` AND potong_mtipe_dtl_new.`kodeitem`=potong_rcn_ri.`iditem`')
            ->where('potong_rcn_ri.`norcn`', $data['norcn'])
            ->groupBy('potong_rcn_ri.`seq`')
            ->countAllResults();
    }

    public function _get_datatables_querydetailkumrealisasi($data)
    {
        $column_order = array("potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.jml", "(potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)", "((potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)-SUM(potong_rcn_ra.`qty`))", "SUM(potong_rcn_ra.`qty`)", "SUM(potong_rcn_ri.`qty`)", "((potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)-SUM(potong_rcn_ri.`qty`))", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`");
        $column_search = array("potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.jml", "(potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)", "((potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)-SUM(potong_rcn_ra.`qty`))", "SUM(potong_rcn_ra.`qty`)", "SUM(potong_rcn_ri.`qty`)", "((potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)-SUM(potong_rcn_ri.`qty`))", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`", "potong_mtipe_dtl_new.`namaitem`");
        $order = array('potong_mtipe_dtl_new.`namaitem`' => 'asc');

        $this->dt->select("potong_rcn_ri.`seq`,potong_mtipe_dtl_new.`namaitem`,((potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)-(jra.`qty`*potong_mtipe_dtl_new.`jml`)) AS balancera,((potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`)-SUM(potong_rcn_ri.`qty`)) AS balanceqty,(jra.`qty`*potong_mtipe_dtl_new.`jml`) AS ra,potong_mtipe_dtl_new.jml AS usespp,(potong_rcn.`jml`*potong_mtipe_dtl_new.`jml`) AS kebutuhan,potong_mtipe_dtl_new.`kodeitem`,potong_rcn_ri.`tgl`,jenismesin,potong_rcn_ri.`norcn`,potong_rcn_ri.`no`,SUM(potong_rcn_ri.`qty`) AS qty,potong_rcn_ri.`grup`,SUM(potong_rcn_ri.`kgm`) AS kgm,qtyp,kgmp,qtyrjm,kgmrjm,qtyprjm,kgmprjm,qtyhmn,kgmhmn,qtyphmn,kgmphmn,qtyska,kgmska,qtypska,kgmpska");
        $this->dt->join('potong_rcn', 'potong_rcn.`norcn`=potong_rcn_ri.`norcn`');
        $this->dt->join('potong_mtipe_dtl_new', 'potong_mtipe_dtl_new.`kodetipe`=potong_rcn.`idtipe` AND potong_mtipe_dtl_new.`kodeitem`=potong_rcn_ri.`iditem`');
        $this->dt->join("(SELECT SUM(IFNULL(potong_rcn_ra.`qty`,0)) AS qty,norcn FROM potong_rcn_ra WHERE norcn='" . $data['norcn'] . "' GROUP BY norcn) AS jra", "jra.`norcn`=potong_rcn.`norcn`", "left");
        $this->dt->join("(SELECT potong_rcn.`norcn`,potong_rcn_ri.`iditem`,SUM(potong_rcn_ri.`qty`) AS qtyp, SUM(potong_rcn_ri.`kgm`) AS kgmp FROM potong_rcn_ri JOIN potong_rcn ON potong_rcn.`norcn`=potong_rcn_ri.`norcn` WHERE potong_rcn.`norcn`='" . $data['norcn'] . "' AND potong_rcn_ri.`tgl` BETWEEN '" . $data['tgldari'] . "' AND '" . $data['tglke'] . "' GROUP BY potong_rcn.`norcn`,potong_rcn_ri.`iditem`) AS kp", 'kp.norcn=potong_rcn.`norcn` AND kp.iditem=potong_rcn_ri.`iditem`', 'left');
        $this->dt->join("(SELECT potong_rcn.`norcn`,potong_rcn_ri.`iditem`,SUM(potong_rcn_ri.`qty`) AS qtyrjm, SUM(potong_rcn_ri.`kgm`) AS kgmrjm FROM potong_rcn_ri JOIN potong_rcn ON potong_rcn.`norcn`=potong_rcn_ri.`norcn` WHERE potong_rcn.`norcn`='" . $data['norcn'] . "' AND potong_rcn_ri.vendor='RJM' GROUP BY potong_rcn.`norcn`,potong_rcn_ri.`iditem`) AS kr", 'kr.norcn=potong_rcn.`norcn` AND kr.iditem=potong_rcn_ri.`iditem`', 'left');
        $this->dt->join("(SELECT potong_rcn.`norcn`,potong_rcn_ri.`iditem`,SUM(potong_rcn_ri.`qty`) AS qtyprjm, SUM(potong_rcn_ri.`kgm`) AS kgmprjm FROM potong_rcn_ri JOIN potong_rcn ON potong_rcn.`norcn`=potong_rcn_ri.`norcn` WHERE potong_rcn.`norcn`='" . $data['norcn'] . "' AND potong_rcn_ri.vendor='RJM' AND potong_rcn_ri.`tgl` BETWEEN '" . $data['tgldari'] . "' AND '" . $data['tglke'] . "' GROUP BY potong_rcn.`norcn`,potong_rcn_ri.`iditem`) AS kpr", 'kpr.norcn=potong_rcn.`norcn` AND kpr.iditem=potong_rcn_ri.`iditem`', 'left');
        $this->dt->join("(SELECT potong_rcn.`norcn`,potong_rcn_ri.`iditem`,SUM(potong_rcn_ri.`qty`) AS qtyhmn, SUM(potong_rcn_ri.`kgm`) AS kgmhmn FROM potong_rcn_ri JOIN potong_rcn ON potong_rcn.`norcn`=potong_rcn_ri.`norcn` WHERE potong_rcn.`norcn`='" . $data['norcn'] . "' AND potong_rcn_ri.vendor='HMN' GROUP BY potong_rcn.`norcn`,potong_rcn_ri.`iditem`) AS kh", 'kh.norcn=potong_rcn.`norcn` AND kh.iditem=potong_rcn_ri.`iditem`', 'left');
        $this->dt->join("(SELECT potong_rcn.`norcn`,potong_rcn_ri.`iditem`,SUM(potong_rcn_ri.`qty`) AS qtyphmn, SUM(potong_rcn_ri.`kgm`) AS kgmphmn FROM potong_rcn_ri JOIN potong_rcn ON potong_rcn.`norcn`=potong_rcn_ri.`norcn` WHERE potong_rcn.`norcn`='" . $data['norcn'] . "' AND potong_rcn_ri.vendor='HMN' AND potong_rcn_ri.`tgl` BETWEEN '" . $data['tgldari'] . "' AND '" . $data['tglke'] . "' GROUP BY potong_rcn.`norcn`,potong_rcn_ri.`iditem`) AS kph", 'kph.norcn=potong_rcn.`norcn` AND kph.iditem=potong_rcn_ri.`iditem`', 'left');
        $this->dt->join("(SELECT potong_rcn.`norcn`,potong_rcn_ri.`iditem`,SUM(potong_rcn_ri.`qty`) AS qtyska, SUM(potong_rcn_ri.`kgm`) AS kgmska FROM potong_rcn_ri JOIN potong_rcn ON potong_rcn.`norcn`=potong_rcn_ri.`norcn` WHERE potong_rcn.`norcn`='" . $data['norcn'] . "' AND potong_rcn_ri.vendor='SKA' GROUP BY potong_rcn.`norcn`,potong_rcn_ri.`iditem`) AS ks", 'ON ks.norcn=potong_rcn.`norcn` AND ks.iditem=potong_rcn_ri.`iditem`', 'left');
        $this->dt->join("(SELECT potong_rcn.`norcn`,potong_rcn_ri.`iditem`,SUM(potong_rcn_ri.`qty`) AS qtypska, SUM(potong_rcn_ri.`kgm`) AS kgmpska FROM potong_rcn_ri JOIN potong_rcn ON potong_rcn.`norcn`=potong_rcn_ri.`norcn` WHERE potong_rcn.`norcn`='" . $data['norcn'] . "' AND potong_rcn_ri.vendor='SKA' AND potong_rcn_ri.`tgl` BETWEEN '" . $data['tgldari'] . "' AND '" . $data['tglke'] . "' GROUP BY potong_rcn.`norcn`,potong_rcn_ri.`iditem`) AS kps", 'kps.norcn=potong_rcn.`norcn` AND kps.iditem=potong_rcn_ri.`iditem`', 'left');
        $this->dt->where('potong_rcn_ri.`norcn`', $data['norcn']);

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

        $this->dt->groupBy('potong_rcn_ri.`iditem`');

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesdetailkumrealisasi($data)
    {
        $this->_get_datatables_querydetailkumrealisasi($data);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filtereddetailkumrealisasi($data)
    {
        $this->_get_datatables_querydetailkumrealisasi($data);
        return $this->dt->countAllResults();
    }

    public function count_alldetailkumrealisasi($data)
    {
        return $this->select("potong_rcn_ri.`seq`")
            ->join('potong_rcn', 'potong_rcn.`norcn`=potong_rcn_ri.`norcn`')
            ->join('potong_mtipe_dtl_new', 'potong_mtipe_dtl_new.`kodetipe`=potong_rcn.`idtipe` AND potong_mtipe_dtl_new.`kodeitem`=potong_rcn_ri.`iditem`')
            ->where('potong_rcn_ri.`norcn`', $data['norcn'])
            ->groupBy('potong_rcn_ri.`iditem`')
            ->countAllResults();
    }
}