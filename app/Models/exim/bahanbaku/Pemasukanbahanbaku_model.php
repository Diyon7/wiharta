<?php

namespace App\Models\exim\bahanbaku;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Pemasukanbahanbaku_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'rech_hdr';
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
        $this->dt = $this->db->table('rech_hdr');
        $this->request = $request;
    }

    public function Allpemasukanbahanbaku($data)
    {
        return $this->db->query("select customer_name from customer where customer_name like '%$data%'")
            ->getResult();
    }

    public function Aju()
    {
        return $this->db->query("SELECT rec_hdr_freight_bill as aju FROM rech_hdr where rec_hdr_freight_bill NOT LIKE '%-%' AND (tgl_beacukai BETWEEN '2022-01-01' AND CURDATE()) GROUP BY rec_hdr_freight_bill ORDER BY rec_hdr_freight_bill")
            ->getResultArray();
    }

    public function Addpemasukanbahanbaku($data)
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
        // return $this->db->query("INSERT INTO beacukai_pemasukanbahanbaku_penerimaan_bj(kode_item, qty_awal, netto_awal, tgl, aju, iduser, created_at) VALUES('" . $data['kode_item'] . "','" . $data['qty_awal'] . "','" . $data['netto_awal'] . "','" . $data['tgl'] . "','" . $data['aju'] . "','" . $data['iduser'] . "','" . $data['created_at'] . "')")
        //     ->getResult();
    }

    public function Allreceiver($data)
    {
        return $this->db->query("SELECT receiver FROM rech_hdr WHERE rec_hdr_rec_date>'2019-01-01' AND receiver LIKE '%$data%' ORDER BY rec_hdr_rec_date DESC LIMIT 20")
            ->getResult();
    }

    public function Ajufromreceiver($data)
    {
        return $this->db->query("SELECT rec_hdr_freight_bill, rec_hdr_rec_date FROM rech_hdr WHERE receiver='$data'")
            ->getRowArray();
    }

    public function Countryfromsupplier($data)
    {
        return $this->db->query("SELECT kode, country FROM ms_country JOIN ms_suplier ON ms_country.idcountry=ms_suplier.idcountry WHERE suplier='$data'")
            ->getRowArray();
    }

    public function Allsupplier($data)
    {
        return $this->db->query("SELECT suplier FROM ms_suplier WHERE suplier LIKE '%$data%'")
            ->getResult();
    }

    public function Editpemasukan($data)
    {
        return $this->db->query("SELECT rec_hist.seq, rech_hdr.`no_beacukai` AS no_pib, rech_hdr.`tgl_beacukai` AS tgl_pib, nilai AS usd
        FROM rech_hdr
        LEFT JOIN rec_hist ON rec_hist.`receiver`=rech_hdr.`receiver`
        LEFT JOIN ven_loc ON ven_loc.`vendor`=rech_hdr.`rec_hdr_vendor`
        WHERE rec_hist.seq='$data'")
            ->getResult();
    }

    public function _get_datatables_querypemasukanbahanbaku()
    {
        $column_order = array(
            null, 'rec_hdr_freight_bill', null, 'rech_hdr.`no_beacukai`', 'rech_hdr.`tgl_beacukai`', 'rech_hdr.receiver',
            'rec_hdr_rec_date', 'rec_item', 'kode_item', 'nama_item', 'satuan', 'kg_real', 'kg_real', null, 'nilai', null, 'ven_loc', null
        );
        $column_search = array(
            null, 'rec_hdr_freight_bill', null, 'rech_hdr.`no_beacukai`', 'rech_hdr.`tgl_beacukai`', 'rech_hdr.receiver',
            'rec_hdr_rec_date', 'rec_item', 'kode_item', 'nama_item', 'satuan', 'kg_real', 'kg_real', null, 'nilai', null, 'ven_loc', null
        );
        $order = array('rech_hdr.`tgl_beacukai`' => 'desc');

        $this->dt->select("rec_hist.seq, 'BC 2.0' as dok,  '1' AS seri ,rec_hdr_freight_bill AS aju, 
        rech_hdr.`no_beacukai` AS no_pib, 
        rech_hdr.`tgl_beacukai` AS tgl_pib, 
        rech_hdr.receiver AS bpb,rec_hdr_rec_date AS tgl_bpb,rec_item,kode_item AS kode,
        nama_item AS nama_barang,satuan AS satuan,IF(kode_item='TY4IFK',kg_real,rec_qty) AS qty,
        kg_real AS kgm,'USD' AS mu,nilai AS usd,'GDBSTK' AS gudang,'0' AS subkon, ven_loc.`ven_loc_country` AS negara");
        $this->dt->join('rec_hist', 'rec_hist.`receiver`=rech_hdr.`receiver`', 'left');
        $this->dt->join('item_ccn', 'item_ccn.item=rec_hist.`rec_item`', 'left');
        $this->dt->join('tb_kode_bb', 'tb_kode_bb.`kode_bb`=item_ccn.`itemBC`', 'left');
        $this->dt->join('ven_loc', 'ven_loc.`vendor`=rech_hdr.`rec_hdr_vendor`', 'left');
        $this->dt->where('item_ccn.klp_beacukai', 'FK');
        $this->dt->where('rech_hdr.`rec_hdr_rec_date`>', '2022-05-01');

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

    public function get_datatablespemasukanbahanbaku()
    {
        $this->_get_datatables_querypemasukanbahanbaku();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredpemasukanbahanbaku()
    {
        $this->_get_datatables_querypemasukanbahanbaku();
        return $this->dt->countAllResults();
    }

    public function count_allpemasukanbahanbaku()
    {
        $this->dt->select("rec_hist.seq,rec_hdr_freight_bill AS aju, 
        rech_hdr.`no_beacukai` AS no_pib, 
        rech_hdr.`tgl_beacukai` AS tgl_pib, 
        rech_hdr.receiver AS bpb,rec_hdr_rec_date AS tgl_bpb,rec_item,kode_item AS kode,
        nama_item AS nama_barang,satuan AS satuan,IF(kode_item='TY4IFK',kg_real,rec_qty) AS qty,
        kg_real AS kgm,'USD' AS mu,nilai AS usd,'GDBSTK' AS gudang,'0' AS subkon, ven_loc.`ven_loc_country` AS negara");
        $this->dt->join('rec_hist', 'rec_hist.`receiver`=rech_hdr.`receiver`', 'left');
        $this->dt->join('item_ccn', 'item_ccn.item=rec_hist.`rec_item`', 'left');
        $this->dt->join('tb_kode_bb', 'tb_kode_bb.`kode_bb`=item_ccn.`itemBC`', 'left');
        $this->dt->join('ven_loc', 'ven_loc.`vendor`=rech_hdr.`rec_hdr_vendor`', 'left');
        $this->dt->where('item_ccn.klp_beacukai', 'FK');
        return  $this->dt->countAllResults();
    }
}
