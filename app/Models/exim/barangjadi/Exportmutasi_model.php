<?php

namespace App\Models\exim\barangjadi;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Exportmutasi_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'beacukai_export';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'qty', 'kgm', 'peb', 'tglpeb', 'inv', 'tglinv', 'aju', 'kode_item', 'customer', 'negara', 'sj', 'tglsj', 'nilai', 'created_at', 'updated_at', 'user_id', 'qtyln'];

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

    public function Edit($data)
    {
        return $this->dt->select("beacukai_export.`qty`,beacukai_export.`seq`,aju, beacukai_export.`kgm` AS kgm, beacukai_export.`peb`, beacukai_export.`tglpeb`,nilai AS nilai, beacukai_export.`inv`,beacukai_export.`kode_item`, beacukai_export.`tglinv`")
            // ->join('item_ccn', 'beacukai_export.`kode_item`=item_ccn.`item`')
            ->where('beacukai_export.seq', $data)
            ->get()->getRowArray();
    }

    public function Headercetak($data)
    {
        return $this->db->query("SELECT beacukai_export.`qty`,aju, beacukai_export.`kgm` AS kgm, beacukai_export.`peb`,
        nobpb,tgbpb, beacukai_export.`tglpeb`,nama_item,tb_kode_fg.kode_konversi AS kkon,nilai AS nilai,namacus,
        beacukai_export.`negara`, beacukai_export.`inv`,beacukai_export.`kode_item`, beacukai_export.`tglinv`, 
        beacukai_export.`aju`, item_ccn.`item_description`,tb_kode_fg.satuan FROM beacukai_export
        JOIN item_ccn ON beacukai_export.`kode_item`=item_ccn.`item`
        JOIN tb_kode_fg ON tb_kode_fg.`kode_bb`=item_ccn.hpl
        JOIN tb_pengeluaran ON tb_pengeluaran.nopeb=beacukai_export.peb
        WHERE (deleted_at IS NULL OR deleted_at='0000-00-00 00:00:00') AND
        beacukai_export.`inv` = '$data'  GROUP BY beacukai_export.inv")->getRowArray();
    }

    public function Itemcetak($data)
    {
        return $this->db->query("SELECT IF(item_ccn.`hpl`='MF',beacukai_export.`kgm`,beacukai_export.`qty`) AS qty,aju, SUM(beacukai_export.`kgm`) AS kgm, beacukai_export.`peb`, beacukai_export.`tglpeb`,nama_item,tb_kode_fg.kode_konversi AS kkon,nilai AS nilai,customer,
        `negara`, beacukai_export.`inv`,beacukai_export.`kode_item`, beacukai_export.`tglinv`, 
        beacukai_export.`aju`, item_ccn.`item_description`,tb_kode_fg.satuan FROM beacukai_export
        JOIN item_ccn ON beacukai_export.`kode_item`=item_ccn.`item`
        JOIN tb_kode_fg ON tb_kode_fg.`kode_bb`=item_ccn.hpl
        WHERE (deleted_at IS NULL OR deleted_at='0000-00-00 00:00:00') AND
        beacukai_export.`inv` = '$data'  GROUP BY beacukai_export.kode_item,beacukai_export.qty ORDER BY item_ccn.`item_description`")->getResultArray();
    }

    public function Itemajucetak($data)
    {
        return $this->db->query("SELECT beacukai_export.`kode_item`,beacukai_export.`aju`,najui.desk,beacukai_export.`qty` AS qtyperitem, SUM(beacukai_export.`kgm`) AS kgm,
        hpl FROM beacukai_export
        JOIN item_ccn ON beacukai_export.`kode_item`=item_ccn.`item`
        LEFT JOIN (SELECT rec_hdr_freight_bill AS noaju, item_description AS desk FROM rech_hdr 
LEFT JOIN rec_hist ON rec_hist.`receiver`=rech_hdr.`receiver`
LEFT JOIN item_ccn_kite ON item_ccn_kite.item=rec_hist.rec_item
WHERE  klp_beacukai='FK' AND rec_hdr_freight_bill NOT IN 
('004505','004573','202111','201895','000312','201891','202105','004494','004488') AND tgl_beacukai>'2022-09-01'
GROUP BY rec_hdr_freight_bill) AS najui ON najui.noaju=beacukai_export.`aju`
        WHERE (deleted_at IS NULL OR deleted_at='0000-00-00 00:00:00') AND beacukai_export.`inv` = '$data'
        GROUP BY beacukai_export.`kode_item`,beacukai_export.`inv`,beacukai_export.`aju`,beacukai_export.`qty`")->getResultArray();
    }

    public function Editi($data)
    {
        return $this->dt->select("beacukai_export.`seq`,beacukai_export.`kode_item`,item_description")
            ->join('item_ccn', 'beacukai_export.`kode_item`=item_ccn.`item`')
            ->where('beacukai_export.seq', $data)
            ->get()->getRowArray();
    }

    public function Allsaldoawal($data)
    {
        return $this->db->query("select customer_name from customer where customer_name like '%$data%'")
            ->getResult();
    }

    public function Peb()
    {
        return $this->db->query("SELECT peb FROM beacukai_export GROUP BY peb")
            ->getResultArray();
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

    public function Addsaldoawal($data)
    {
        return $this->db->query("SELECT rec_hdr_freight_bill as aju FROM rech_hdr where rec_hdr_freight_bill NOT LIKE '%-%' AND (tgl_beacukai BETWEEN '2022-01-01' AND CURDATE()) GROUP BY rec_hdr_freight_bill ORDER BY rec_hdr_freight_bill")
            ->getResultArray();
    }

    public function Coba()
    {
        return $this->select("beacukai_export.`seq`,beacukai_export.`peb`,beacukai_export.`tglpeb`,beacukai_export.`kode_item`,nama_item,item_ccn.`item_description`,beacukai_export.`qty`,beacukai_export.`kgm`,aju,nilai,beacukai_export.`inv`,beacukai_export.`tglinv`,nobpb,tgbpb,namacus,tb_pengeluaran.`negara`,beacukai_export.`updated_at`")
            ->join('item_ccn', 'beacukai_export.`kode_item`=item_ccn.`item`')
            ->join('tb_kode_fg', 'tb_kode_fg.`kode_bb`=item_ccn.hpl')
            ->join('tb_pengeluaran', 'tb_pengeluaran.`inv`=beacukai_export.`inv`', 'left')
            ->groupStart()
            ->like('beacukai_export.`seq`', '%')
            ->groupEnd()
            ->limit(10)
            ->get()->getResultArray();
    }

    public function Addmutasidtl($data)
    {
        return $this->dt->insert([
            'kode' => $data['kode'],
            'item' => $data['item'],
            'qty' => $data['qty'],
            'kg' => $data['kg'],
            'no_aju' => $data['no_aju'],
            'code' => $data['code'],
            'iduser' => $data['iduser'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at']
        ]);
        // return $this->db->query("INSERT INTO beacukai_saldoawal_penerimaan_bj(kode_item, qty_awal, netto_awal, tgl, aju, iduser, created_at) VALUES('" . $data['kode_item'] . "','" . $data['qty_awal'] . "','" . $data['netto_awal'] . "','" . $data['tgl'] . "','" . $data['aju'] . "','" . $data['iduser'] . "','" . $data['created_at'] . "')")
        //     ->getResult();
    }
    public function Addmutasihdr($data)
    {
        return $this->dt->insert([
            'kode' => $data['kode'],
            'tgl' => $data['tgl'],
            'lokasi_asal' => $data['lokasi_asal'],
            'lokasi_tujuan' => $data['lokasi_tujuan'],
            'analyst_asal' => $data['analyst_asal'],
            'analyst_tujuan' => $data['analyst_tujuan'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
        ]);
        // return $this->db->query("INSERT INTO beacukai_saldoawal_penerimaan_bj(kode_item, qty_awal, netto_awal, tgl, aju, iduser, created_at) VALUES('" . $data['kode_item'] . "','" . $data['qty_awal'] . "','" . $data['netto_awal'] . "','" . $data['tgl'] . "','" . $data['aju'] . "','" . $data['iduser'] . "','" . $data['created_at'] . "')")
        //     ->getResult();
    }

    public function Allitem()
    {
        return $this->db->query("SELECT beacukai_mutasi_dtl.item,item_description from beacukai_mutasi_dtl join item_ccn on item_ccn.item=beacukai_mutasi_dtl.item group by beacukai_mutasi_dtl.item")
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

    public function _get_datatables_queryexportmutasi($data)
    {
        $column_order = array('beacukai_export.peb', 'beacukai_export.tglpeb', 'beacukai_export.kode_item', 'nama_item', 'item_ccn.item_description', 'beacukai_export.qty', 'beacukai_export.kgm', 'aju', 'nilai', 'beacukai_export.inv', 'beacukai_export.tglinv', 'nobpb', 'tgbpb',  'namacus', 'tb_pengeluaran.negara', 'beacukai_export.`user_id`', 'beacukai_export.updated_at',  'beacukai_export.updated_at');
        $column_search = array('beacukai_export.peb', 'beacukai_export.tglpeb', 'beacukai_export.kode_item', 'nama_item', 'item_ccn.item_description', 'beacukai_export.qty', 'beacukai_export.kgm', 'aju', 'nilai', 'beacukai_export.inv', 'beacukai_export.tglinv', 'nobpb', 'tgbpb',  'namacus', 'tb_pengeluaran.negara', 'beacukai_export.`user_id`', 'beacukai_export.updated_at',  'beacukai_export.updated_at');
        $order = array('beacukai_export.seq' => 'desc');

        $this->select("beacukai_export.seq,peb,tglpeb,beacukai_export.kode_item,nama_item,item_description,beacukai_export.qty,beacukai_export.kgm,aju,nilai,beacukai_export.inv,beacukai_export.tglinv,nobpb,beacukai_export.`user_id`,tgbpb,namacus,tb_pengeluaran.negara,beacukai_export.updated_at");
        $this->join('item_ccn', 'beacukai_export.kode_item=item_ccn.item');
        $this->join('tb_kode_fg', 'tb_kode_fg.kode_bb=item_ccn.hpl');
        $this->join('tb_pengeluaran', 'tb_pengeluaran.inv=beacukai_export.inv AND tb_pengeluaran.`nopeb`=beacukai_export.`peb`', 'left');
        $this->like('beacukai_export.kode_item', $data['itemfilter']);
        $this->like('beacukai_export.peb', $data['pebfilter']);
        if ($data['tgldari'] != '') {
            $this->where('tglpeb>=', $data['tgldari']);
        }
        if ($data['tglke'] != '') {
            $this->where('tglpeb<=', $data['tglke']);
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

        $this->groupBy('beacukai_export.seq');

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesexportmutasi($data)
    {
        $this->_get_datatables_queryexportmutasi($data);
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredexportmutasi($data)
    {
        $this->_get_datatables_queryexportmutasi($data);
        return $this->countAllResults();
    }

    public function count_allexportmutasi()
    {
        return $this->select("beacukai_export.seq,peb,tglpeb,beacukai_export.kode_item,nama_item,item_description,beacukai_export.qty,beacukai_export.kgm,aju,nilai,beacukai_export.inv,tglinv,nobpb,tgbpb,namacus,tb_pengeluaran.negara,updated_at")
            ->join('item_ccn', 'beacukai_export.kode_item=item_ccn.item')
            ->join('tb_kode_fg', 'tb_kode_fg.kode_bb=item_ccn.hpl')
            ->join('tb_pengeluaran', 'tb_pengeluaran.inv=beacukai_export.inv AND tb_pengeluaran.`nopeb`=beacukai_export.`peb`', 'left')
            ->groupBy('beacukai_export.seq')
            ->countAllResults();
    }
}
