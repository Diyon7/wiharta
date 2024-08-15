<?php

namespace App\Models\exim\barangjadi;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Saldoawal_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'beacukai_saldoawal_penerimaan_bj';
    protected $primaryKey = 'sec';

    protected $allowedFields = ['sec', 'kode_item', 'qty_awal', 'netto_awal', 'tgl', 'aju', 'iduser', 'created_at'];

    protected $request;
    protected $dt;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('beacukai_saldoawal_penerimaan_bj');
        $this->request = $request;
    }

    public function Allsaldoawal($data)
    {
        return $this->db->query("select customer_name from customer where customer_name like '%$data%'")
            ->getResult();
    }

    public function Aju()
    {
        return $this->db->query("SELECT rec_hdr_freight_bill AS aju,item_description FROM rech_hdr 
        left join rec_hist on rec_hist.receiver=rech_hdr.receiver
        left join item_ccn on item_ccn.item=rec_hist.rec_item
        WHERE rec_hdr_freight_bill NOT LIKE '%-%' AND rec_hdr_rec_date > '2022-01-01' and klp_beacukai='FK' GROUP BY rec_hdr_freight_bill")
            ->getResultArray();
    }

    public function Lokasi()
    {
        return $this->db->query("SELECT analyst, analyst_code, analyst_name FROM beacukai_analyst")
            ->getResultArray();
    }

    public function Addsaldoawal($data)
    {
        return $this->db->query("SELECT rec_hdr_freight_bill as aju FROM rech_hdr where rec_hdr_freight_bill NOT LIKE '%-%' AND (tgl_beacukai BETWEEN '2022-01-01' AND CURDATE()) GROUP BY rec_hdr_freight_bill ORDER BY rec_hdr_freight_bill")
            ->getResultArray();
    }

    public function Addrcustomer($data)
    {
        return $this->dt->insert([
            'kode_item' => $data['kode_item'],
            'qty_awal' => $data['qty_awal'],
            'netto_awal' => $data['netto_awal'],
            'tgl' => $data['tgl'],
            'aju' => $data['aju'],
            'iduser' => $data['iduser'],
            'created_at' => $data['created_at']
        ]);
        // return $this->db->query("INSERT INTO beacukai_saldoawal_penerimaan_bj(kode_item, qty_awal, netto_awal, tgl, aju, iduser, created_at) VALUES('" . $data['kode_item'] . "','" . $data['qty_awal'] . "','" . $data['netto_awal'] . "','" . $data['tgl'] . "','" . $data['aju'] . "','" . $data['iduser'] . "','" . $data['created_at'] . "')")
        //     ->getResult();
    }

    public function Allitem($data)
    {
        return $this->db->query("SELECT beacukai_mutasi_dtl.item,item_description from beacukai_mutasi_dtl left join item_ccn on item_ccn.item=beacukai_mutasi_dtl.item join beacukai_export on item_ccn.item=beacukai_export.kode_item where item_description like '%$data%' or beacukai_mutasi_dtl.item like '%$data%' group by beacukai_mutasi_dtl.item")
            ->getResult();
    }

    public function _get_datatables_querysaldoawal()
    {
        $column_order = array('sec', 'kode_item', 'item_description', 'qty_awal', 'netto_awal', 'tgl', 'aju');
        $column_search = array('sec', 'kode_item', 'item_description', 'qty_awal', 'netto_awal', 'tgl', 'aju');
        $order = array('created_at' => 'desc');

        $this->dt->select("sec, kode_item, item_ccn_new.item_description, qty_awal, netto_awal, tgl, aju, iduser, created_at");
        $this->dt->join('item_ccn_new', 'item_ccn_new.item=beacukai_saldoawal_penerimaan_bj.kode_item', 'left');

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

    public function get_datatablessaldoawal()
    {
        $this->_get_datatables_querysaldoawal();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredsaldoawal()
    {
        $this->_get_datatables_querysaldoawal();
        return $this->dt->countAllResults();
    }

    public function count_allsaldoawal()
    {
        return $this->dt->select("sec, kode_item, item_ccn_new.item_description, qty_awal, netto_awal, tgl, aju, iduser, created_at")
            ->join('item_ccn_new', 'item_ccn_new.item=beacukai_saldoawal_penerimaan_bj.kode_item');
    }
}