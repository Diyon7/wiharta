<?php

namespace App\Models\exim\export;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Eximitv_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'tb_pengeluaran';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'nopeb', 'tgpeb', 'nobpb', 'tgbpb', 'idcus', 'idcus', 'namacus', 'negara', 'kodeitem', 'kodekonversi', 'namabrg', 'desk', 'satuan', 'qty', 'kgm', 'mu', 'fob', 'nospp', 'inv', 'tglinv', 'fin', 'user', 'created_at', 'updated_at'];

    protected $request;
    protected $dt;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('tb_pengeluaran');
        $this->request = $request;
    }

    public function Add($data)
    {
        return $this->dt->select("tb_pengeluaran.`seq`,nopeb,tgpeb,nobpb,tgbpb,idcus,namacus,m_negara.`negara`,kodeitem,kodekonversi,namabrg,desk,satuan,qty,kgm,mu,fob,nospp,inv,tglinv,fin,item_ccn.`item_description`")
            ->join('item_ccn', 'item_ccn.`item`=tb_pengeluaran.`kodeitem`')
            ->join('m_negara', 'm_negara.`kode`=tb_pengeluaran.`negara`')
            ->where('tb_pengeluaran.`seq`', $data)
            ->get()->getRowArray();
    }

    public function Allcustomer()
    {
        return $this->db->query("SELECT customer,ms_country.`country` AS negara FROM ms_customer JOIN ms_country ON ms_country.`idcountry`=ms_customer.`idcountry`")
            ->getResultArray();
    }

    public function _get_datatables_queryeximitv()
    {
        $column_order = array('tb_pengeluaran.`nopeb`', 'tb_pengeluaran.`tgpeb`', 'nobpb', 'tgbpb', 'namacus', 'tb_pengeluaran.`negara`', 'kodeitem', 'desk', 'tb_pengeluaran.`qty`', 'tb_pengeluaran.`kgm`', 'fob', 'tb_pengeluaran.inv', 'tb_pengeluaran.inv');
        $column_search = array('tb_pengeluaran.`nopeb`', 'tb_pengeluaran.`tgpeb`', 'nobpb', 'tgbpb', 'namacus', 'tb_pengeluaran.`negara`', 'kodeitem', 'desk', 'tb_pengeluaran.`qty`', 'tb_pengeluaran.`kgm`', 'fob', 'tb_pengeluaran.inv', 'tb_pengeluaran.inv');
        $order = array('tb_pengeluaran.`tgpeb`' => 'desc');

        $this->dt->select("tb_pengeluaran.`seq`,tb_pengeluaran.`nopeb`,tb_pengeluaran.`tgpeb`,nobpb,tgbpb,namacus,tb_pengeluaran.`negara`,kodeitem,desk,tb_pengeluaran.`qty`,tb_pengeluaran.`kgm`,fob,tb_pengeluaran.inv");
        $this->dt->join('beacukai_export', 'tb_pengeluaran.nopeb=beacukai_export.peb AND tb_pengeluaran.fob=beacukai_export.nilai', 'left');
        $this->dt->where("CONCAT(' ', tb_pengeluaran.`nopeb`, tb_pengeluaran.`kodeitem`,tb_pengeluaran.`fob`) NOT IN (SELECT CONCAT(' ' ,peb, kode_item, nilai) FROM beacukai_export GROUP BY peb, kode_item, nilai)");
        $this->dt->where('tb_pengeluaran.`tgpeb`>', '2024-01-31');

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

    public function get_datatableseximitv()
    {
        $this->_get_datatables_queryeximitv();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredeximitv()
    {
        $this->_get_datatables_queryeximitv();
        return $this->dt->countAllResults();
    }

    public function count_alleximitv()
    {
        return $this->dt->select("tb_pengeluaran.`seq`")
            ->where("CONCAT(' ', tb_pengeluaran.`nopeb`, tb_pengeluaran.`kodeitem`,tb_pengeluaran.`fob`) NOT IN (SELECT CONCAT(' ' ,peb, kode_item, nilai) FROM beacukai_export GROUP BY peb, kode_item, nilai)")
            ->where('tb_pengeluaran.`tgpeb`>', '2024-01-31')
            ->countAllResults();
    }
}
