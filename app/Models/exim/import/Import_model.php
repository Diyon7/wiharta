<?php

namespace App\Models\exim\import;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Import_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'beacukai_pib';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'fasilitas', 'id_vendor', 'aju', 'noaju', 'no_coo', 'tgl_coo', 'emkl_ptj', 'pib', 'tglpib', 'kode_item', 'desk', 'itembc', 'qty', 'kgm', 'nilai', 'hscode', 'bl', 'party', 'etd', 'eta', 'eta_wka', 'term', 'inv', 'mu', 'nilai_pib_usd', 'nilai_pib_idr', 'bm', 'bmt_bmad_bmi_bmtp', 'ppn', 'pph', 'remark', 'bm_dibebaskan', 'ppn_tidakdipungut', 'total_payment_pib', 'created_at', 'update_at', 'user'];

    protected $request;
    protected $dt;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('beacukai_pib');
        $this->request = $request;
    }

    public function Aju()
    {
        return $this->db->query("SELECT item,item_description from item_ccn where klp_beacukai IN ('NF','FK','FNK')")
            ->getResultArray();
    }

    public function Allitem($data)
    {
        return $this->db->query("SELECT item_ccn.`item` AS item,klp_beacukai,item_description,IF(pib.`item` IS NULL,'(Belum Pernah Dipakai di import)','') AS status FROM item_ccn LEFT JOIN (SELECT kode_item AS item FROM beacukai_pib GROUP BY kode_item) AS pib ON item_ccn.item=pib.item WHERE item_description LIKE '%$data%' OR item_ccn.`item` LIKE '%$data%' ORDER BY pib.`item` DESC LIMIT 5")
            ->getResultArray();
    }

    public function Itemimport($data)
    {
        return $this->db->query("SELECT item_description,itembc FROM item_ccn WHERE item LIKE '%$data%'")
            ->getRowArray();
    }

    public function Penjualimport()
    {
        return $this->db->query("SELECT seq, penjual, pengirim, negara FROM beacukai_vendor ORDER BY penjual ASC")
            ->getResultArray();
    }

    public function Rab()
    {
        return $this->db->query("select rab_20240103.`item`,item_description,max(tgl_RAB) as tgl,harga
        from rab_20240103 join item_ccn on item_ccn.`item`=rab_20240103.`item`
        where tgl_RAB>'2023-11-29'
        group by rab_20240103.`item`")
            ->getResultArray();
    }

    public function Dataimport($data)
    {
        return $this->select("beacukai_pib.`seq` as seq,aju,pengirim,HSCODE,penjual,pib,tglpib,kgm,desk,no_coo,tgl_coo,emkl_ptj,kode_item,id_vendor,qty,kgm,nilai,bl,negara,party,etd,eta,eta_wka,fasilitas,term,inv,MU,nilai_pib_usd,nilai_pib_idr,bm,bmt_bmad_bmi_bmtp,ppn,pph,beacukai_pib.`remark`,bm_dibebaskan,ppn_tidakdipungut,total_payment_pib")
            ->join('beacukai_vendor', 'beacukai_vendor.`seq`=beacukai_pib.`id_vendor`', 'left')
            ->where('beacukai_pib.`seq`', $data)
            ->get()
            ->getRowArray();
    }

    public function _get_datatables_queryimport($data)
    {
        $column_order = array('fasilitas', 'tglbapb', 'beacukai_pib.noaju', 'beacukai_pib.pib', 'beacukai_pib.tglpib', 'beacukai_pib.tglpib', 'beacukai_pib.hscode', 'bapb', 'tglbapb', 'beacukai_pib.kode_item', 'tb_kode_bb.kode_item', 'nama_item', 'beacukai_pib.desk', 'satuan', 'beacukai_pib.qty', 'beacukai_pib.kgm', 'beacukai_pib.kgm', 'beacukai_pib.nilai', 'beacukai_pib.nilai', 'beacukai_pib.nilai', 'beacukai_pib.nilai', 'ven_loc_country', 'ven_loc_country');
        $column_search = array('fasilitas', 'tglbapb', 'beacukai_pib.noaju', 'beacukai_pib.pib', 'beacukai_pib.tglpib', 'beacukai_pib.tglpib', 'beacukai_pib.hscode', 'bapb', 'tglbapb', 'beacukai_pib.kode_item', 'tb_kode_bb.kode_item', 'nama_item', 'beacukai_pib.desk', 'satuan', 'beacukai_pib.qty', 'beacukai_pib.kgm', 'beacukai_pib.kgm', 'beacukai_pib.nilai', 'beacukai_pib.nilai', 'beacukai_pib.nilai', 'beacukai_pib.nilai', 'ven_loc_country', 'ven_loc_country');
        $order = array('beacukai_pib.tglpib' => 'desc');

        $this->select("fasilitas,beacukai_pib.seq,beacukai_pib.noaju,beacukai_pib.pib,beacukai_pib.tglpib,beacukai_pib.hscode,beacukai_pib.desk,beacukai_pib.kode_item,beacukai_pib.qty,beacukai_pib.kgm,beacukai_pib.nilai,bapb,tglbapb,satuan,tb_kode_bb.kode_item as itm,nama_item,ven_loc_country");
        $this->join('tb_kode_bb', 'tb_kode_bb.kode_bb=beacukai_pib.itembc', 'left');
        $this->join('(SELECT rech_hdr.receiver AS bapb,rech_hdr.`rec_hdr_freight_bill` AS aju,rech_hdr.`rec_hdr_rec_date` AS tglbapb,ven_loc_country FROM rech_hdr left join ven_loc on ven_loc.vendor=rech_hdr.rec_hdr_vendor) as mrp', 'mrp.aju=beacukai_pib.noaju', 'left');
        $this->where('tglbapb>', '2021-01-01');
        if ($data['tgldari'] != '') {
            $this->where('tglbapb>=', $data['tgldari']);
        }
        if ($data['tglke'] != '') {
            $this->where('tglbapb<=', $data['tglke']);
        }

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

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesimport($data)
    {
        $this->_get_datatables_queryimport($data);
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredimport($data)
    {
        $this->_get_datatables_queryimport($data);
        return $this->countAllResults();
    }

    public function count_allimport()
    {
        return  $this->select("bapb,nama_item,ven_loc_country")
            ->join('tb_kode_bb', 'tb_kode_bb.kode_bb=beacukai_pib.itembc', 'left')
            ->join('(SELECT rech_hdr.receiver AS bapb,rech_hdr.`rec_hdr_freight_bill` AS aju,rech_hdr.`rec_hdr_rec_date` AS tglbapb,ven_loc_country FROM rech_hdr left join ven_loc on ven_loc.vendor=rech_hdr.rec_hdr_vendor) as mrp', 'mrp.aju=beacukai_pib.noaju', 'left')
            ->where('tglbapb>', '2021-01-01')
            ->countAllResults();
    }

    public function _get_datatables_queryimportjkt($data)
    {
        $column_order = array('aju', 'aju', 'pengirim', 'HSCODE', 'penjual', 'pib', 'tglpib', 'kgm', 'desk', 'no_coo', 'tgl_coo', 'emkl_ptj', 'bl', 'negara', 'party', 'etd', 'eta', 'eta_wka', 'fasilitas', 'term', 'inv', 'MU', 'nilai_pib_usd', 'nilai_pib_idr', 'bm', 'bmt_bmad_bmi_bmtp', 'ppn', 'pph', 'beacukai_pib.`remark`', 'bm_dibebaskan', 'ppn_tidakdipungut', 'total_payment_pib', 'total_payment_pib', 'total_payment_pib');
        $column_search = array('aju', 'aju', 'pengirim', 'HSCODE', 'penjual', 'pib', 'tglpib', 'kgm', 'desk', 'no_coo', 'tgl_coo', 'emkl_ptj', 'bl', 'negara', 'party', 'etd', 'eta', 'eta_wka', 'fasilitas', 'term', 'inv', 'MU', 'nilai_pib_usd', 'nilai_pib_idr', 'bm', 'bmt_bmad_bmi_bmtp', 'ppn', 'pph', 'beacukai_pib.`remark`', 'bm_dibebaskan', 'ppn_tidakdipungut', 'total_payment_pib', 'total_payment_pib', 'total_payment_pib');
        $order = array('tglpib' => 'desc');

        $this->select("beacukai_pib.`seq` as seq,aju,pengirim,HSCODE,penjual,pib,tglpib,kgm,desk,no_coo,tgl_coo,emkl_ptj,bl,negara,party,etd,eta,eta_wka,fasilitas,term,inv,MU,nilai_pib_usd,nilai_pib_idr,bm,bmt_bmad_bmi_bmtp,ppn,pph,beacukai_pib.`remark`,bm_dibebaskan,ppn_tidakdipungut,total_payment_pib");
        $this->join('beacukai_vendor', 'beacukai_vendor.`seq`=beacukai_pib.`id_vendor`', 'left');
        if ($data['tgldari'] != '') {
            $this->where('tglpib>=', $data['tgldari']);
        }
        if ($data['tglke'] != '') {
            $this->where('tglpib<=', $data['tglke']);
        }

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

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesimportjkt($data)
    {
        $this->_get_datatables_queryimportjkt($data);
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredimportjkt($data)
    {
        $this->_get_datatables_queryimportjkt($data);
        return $this->countAllResults();
    }

    public function count_allimportjkt()
    {
        return  $this->select("aju,pengirim,HSCODE,penjual,pib,tglpib,kgm,desk,no_coo,tgl_coo,emkl_ptj,bl,negara,party,etd,eta,eta_wka,fasilitas,term,inv,MU,nilai_pib_usd,nilai_pib_idr,bm,bmt_bmad_bmi_bmtp,ppn,pph,beacukai_pib.`remark`,bm_dibebaskan,ppn_tidakdipungut,total_payment_pib")
            ->join('beacukai_vendor', 'beacukai_vendor.`seq`=beacukai_pib.`id_vendor`', 'left')
            ->countAllResults();
    }
}