<?php

namespace App\Models\exim\jurnal;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Jurnalpembeliandetail_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'beacukai_jurnal_pembelian_detail';
    protected $primaryKey = 'id';

    protected $allowedFields = ['seq', 'tgl', 'bukti', 'id', 'bapb', 'tglbapb', 'aju', 'po', 'vendor', 'fasilitas', 'item', 'satuan', 'qty', 'kgm', 'debit', 'kredit', 'kurs', 'mu', 'created_at', 'updated_at'];

    protected $request;
    protected $dt;
    protected $pib;
    protected $rh;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('beacukai_jurnal_pembelian_detail');
        $this->pib = $this->db->table('beacukai_pib');
        $this->rh = $this->db->table('rech_hdr');
        $this->request = $request;
    }

    public function Aju()
    {
        return $this->db->query("SELECT rec_hdr_freight_bill as aju FROM rech_hdr where rec_hdr_freight_bill NOT LIKE '%-%' AND (tgl_beacukai BETWEEN '2022-01-01' AND CURDATE()) GROUP BY rec_hdr_freight_bill ORDER BY rec_hdr_freight_bill")
            ->getResultArray();
    }

    public function Lokasi()
    {
        return $this->db->query("SELECT analyst, analyst_name FROM beacukai_analyst")
            ->getResultArray();
    }

    public function Addsaldoawal()
    {
        return $this->rh->select("id,rech_hdr.receiver AS bapb,rec_hdr_rec_date AS tgl_bapb,rec_hdr_freight_bill AS aju,rech_hdr.rec_order_num AS po, ven_loc_name AS supplyer,klp_beacukai AS fasilitas,rec_item,item_description,item_ccn_buy_um as stn,sum(rec_qty) as qt,sum(kg_real) as kg,rec_hist.`nilai`,beacukai_jurnal_pembelian.`updated_at`")
            ->join('rec_hist', 'rec_hist.`receiver`=rech_hdr.`receiver`', 'left')
            ->join('beacukai_jurnal_pembelian', 'beacukai_jurnal_pembelian.`bapb`=rech_hdr.`receiver` AND beacukai_jurnal_pembelian.`item`=rec_hist.`rec_item`', 'left')
            ->join('item_ccn', 'item_ccn.item=rec_hist.`rec_item`', 'left')
            ->join('ven_loc', 'ven_loc.`vendor`=rech_hdr.`rec_hdr_vendor`', 'left')
            ->where('klp_beacukai', 'FK')
            ->groupBy('rec_hist.receiver,rec_item')
            ->get()->getResultArray();
    }

    public function Allitem()
    {
        return $this->db->query("SELECT beacukai_mutasi_dtl.item,item_description from beacukai_mutasi_dtl join item_ccn on item_ccn.item=beacukai_mutasi_dtl.item group by beacukai_mutasi_dtl.item")
            ->getResultArray();
    }
    public function Allanalyst()
    {
        return $this->db->query("SELECT analyst_code,analyst_name FROM beacukai_analyst")
            ->getResultArray();
    }

    public function Kodelok($data)
    {
        return $this->db->query("SELECT Analyst FROM beacukai_analyst WHERE analyst_code='$data'")
            ->getRowArray();
    }

    public function Ceksurat($data)
    {
        return $this->db->query("SELECT * FROM beacukai_mutasi_hdr WHERE kode='$data'")
            ->getNumRows();
    }

    public function Jurnalpembelianedit($isi)
    {
        return $this->pib->select("beacukai_pib.`seq`,beacukai_jurnal_pembelian.`id`,kurs,beacukai_pib.`noaju` AS aju,beacukai_pib.`fasilitas`,beacukai_pib.`kode_item` AS rec_item,beacukai_pib.`desk` AS item_description,beacukai_pib.`qty` AS qt,beacukai_pib.`kgm` AS kg,beacukai_pib.`nilai`,mrp.po,mrp.bapb,mrp.tglbapb AS tgl_bapb,tb_kode_bb.`satuan` AS stn,ven_loc_name AS supplyer,ven_loc_country")
            ->join('tb_kode_bb', 'tb_kode_bb.kode_bb=beacukai_pib.itembc', 'left')
            ->join('(SELECT rech_hdr.receiver AS bapb,rech_hdr.`rec_hdr_freight_bill` AS aju,rech_hdr.`no_beacukai` AS pib,rech_hdr.`rec_hdr_rec_date` AS tglbapb,ven_loc_country,ven_loc_name, rech_hdr.`rec_order_num` AS po FROM rech_hdr LEFT JOIN ven_loc ON ven_loc.vendor=rech_hdr.rec_hdr_vendor) AS mrp', 'mrp.aju=beacukai_pib.noaju AND mrp.pib=beacukai_pib.`pib`', 'left')
            ->join('beacukai_jurnal_pembelian', 'beacukai_jurnal_pembelian.`bapb`=mrp.bapb AND beacukai_jurnal_pembelian.`item`=beacukai_pib.`kode_item`', 'left')
            ->join('beacukai_jurnal_pembelian_detail', 'beacukai_jurnal_pembelian_detail.`id`=beacukai_jurnal_pembelian.`id`', 'left')
            ->where('beacukai_pib.`seq`', $isi)
            ->get()->getRowArray();
    }

    public function Idmaxjurnalpembelian()
    {
        return $this->db->query("SELECT (MAX(id)+1) AS bjpmaxid FROM beacukai_jurnal_pembelian")
            ->getRowArray();
    }
}
