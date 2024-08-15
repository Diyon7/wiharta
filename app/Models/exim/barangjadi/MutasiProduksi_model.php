<?php

namespace App\Models\exim\barangjadi;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class MutasiProduksi_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'beacukai_mutasi_dtl';
    protected $primaryKey = 'sec';

    protected $allowedFields = ['sec', 'kode', 'item', 'qty', 'kg', 'no_aju', 'code', 'iduser', 'created_at', 'updated_at'];

    protected $request;
    protected $dt;
    protected $hd;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('beacukai_mutasi_dtl');
        $this->hd = $this->db->table('beacukai_mutasi_hdr');
        $this->request = $request;
    }

    public function Allsaldoawal($data)
    {
        return $this->db->query("select customer_name from customer where customer_name like '%$data%'")
            ->getResult();
    }

    public function Header($data)
    {
        return $this->db->query("SELECT beacukai_mutasi_hdr.`analyst_asal`,beacukai_mutasi_hdr.`analyst_tujuan`,beacukai_mutasi_hdr.kode2 AS kode2,beacukai_mutasi_hdr.`tgl` AS tgl,asl.asal,tjn.tujuan FROM beacukai_mutasi_hdr
        LEFT JOIN (SELECT analyst,analyst_name AS asal FROM beacukai_analyst) AS asl ON asl.analyst=beacukai_mutasi_hdr.lokasi_asal
        LEFT JOIN (SELECT analyst,analyst_name AS tujuan FROM beacukai_analyst) AS tjn ON tjn.analyst=beacukai_mutasi_hdr.lokasi_tujuan
        WHERE beacukai_mutasi_hdr.kode2 LIKE CONCAT(LEFT('$data',16),'%')")
            ->getRowArray();
    }

    public function Itemreport($data)
    {
        return $this->db->query("SELECT beacukai_mutasi_hdr.kode2,beacukai_mutasi_hdr.kode,desk,beacukai_mutasi_dtl.code,kgit.kgm AS totalkg,beacukai_mutasi_hdr.`tgl`,beacukai_mutasi_dtl.no_aju,
        beacukai_mutasi_dtl.item,tb_kode_fg.`kode_item`,tb_kode_fg.`nama_item`,item_ccn.`item_description`,
        IF(beacukai_mutasi_hdr.`lokasi_tujuan` ='GDBFTK',tb_kode_fg.satuan,tb_kode_bb.`satuan`) AS satuan,IF(tb_kode_fg.`nama_item`='PPMF',SUM(beacukai_mutasi_dtl.`kg`),namaqty.totalqty) AS alltotalqty, 
        SUM(beacukai_mutasi_dtl.`kg`) AS kgm ,beacukai_mutasi_hdr.urut,beacukai_mutasi_hdr.kode2
        FROM beacukai_mutasi_hdr
        JOIN beacukai_mutasi_dtl ON beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode
        LEFT JOIN (SELECT rec_hdr_freight_bill AS noaju, item_description AS desk FROM rech_hdr 
LEFT JOIN rec_hist ON rec_hist.`receiver`=rech_hdr.`receiver`
LEFT JOIN item_ccn ON item_ccn.item=rec_hist.rec_item
WHERE  klp_beacukai='FK' AND rec_hdr_freight_bill NOT IN 
('004505','004573','202111','201895','000312','201891','202105','004494','004488') AND tgl_beacukai>'2022-09-01'
GROUP BY rec_hdr_freight_bill) AS najui ON najui.noaju=beacukai_mutasi_dtl.`no_aju`
        JOIN item_ccn ON item_ccn.item=beacukai_mutasi_dtl.`item`
        LEFT JOIN tb_kode_fg ON tb_kode_fg.`kode_bb`=item_ccn.`hpl`
        LEFT JOIN tb_kode_bb ON tb_kode_bb.`kode_bb`=item_ccn.`itemBC`
        LEFT JOIN (SELECT beacukai_mutasi_dtl.item,SUM(beacukai_mutasi_dtl.`kg`) AS kgm FROM beacukai_mutasi_hdr
        JOIN beacukai_mutasi_dtl ON beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode
        JOIN item_ccn ON item_ccn.item=beacukai_mutasi_dtl.`item` WHERE (deleted_at IS NULL OR deleted_at='0000-00-00 00:00:00')
        AND CONCAT(beacukai_mutasi_hdr.kode2,'/',IFNULL(item_ccn.`hpl`,'')) LIKE '$data%' GROUP BY item) AS kgit ON kgit.item=beacukai_mutasi_dtl.item
        LEFT JOIN (SELECT beacukai_mutasi_hdr.kode,tgl,beacukai_mutasi_dtl.`no_aju`,beacukai_mutasi_dtl.item,kode_item,nama_item,item_description,tb_kode_fg.satuan,IF(nama_item='PPMF',SUM(kg),SUM(qty)) AS totalqty
                                FROM beacukai_mutasi_dtl
                                JOIN beacukai_mutasi_hdr ON beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode
                                JOIN item_ccn ON item_ccn.item=beacukai_mutasi_dtl.`item`
                                LEFT JOIN tb_kode_fg ON tb_kode_fg.`kode_bb`=item_ccn.`hpl` WHERE (deleted_at IS NULL OR deleted_at='0000-00-00 00:00:00') AND IF(beacukai_mutasi_hdr.`lokasi_tujuan` ='GDBFTK',beacukai_mutasi_dtl.`code`='1',beacukai_mutasi_dtl.`code` LIKE '%') AND
                                CONCAT(beacukai_mutasi_hdr.kode2,'/',IFNULL(item_ccn.`hpl`,'')) LIKE '$data%' GROUP BY beacukai_mutasi_dtl.`item`,beacukai_mutasi_dtl.`no_aju`) AS namaqty ON namaqty.item=beacukai_mutasi_dtl.item AND namaqty.no_aju=beacukai_mutasi_dtl.no_aju
        WHERE (deleted_at IS NULL OR deleted_at='0000-00-00 00:00:00')
        AND CONCAT(beacukai_mutasi_hdr.kode2,'/',IFNULL(item_ccn.`hpl`,'')) LIKE '$data%'
        AND beacukai_mutasi_dtl.no_aju <> 0
        GROUP BY beacukai_mutasi_dtl.`item`,beacukai_mutasi_dtl.`no_aju`  ORDER BY beacukai_mutasi_dtl.`item`,beacukai_mutasi_dtl.code")
            ->getResultArray();
    }


    public function Itemreport2($data)
    {
        $item = $this->db->query("SELECT beacukai_mutasi_hdr.kode2,beacukai_mutasi_hdr.kode,desk,beacukai_mutasi_hdr.`tgl`,beacukai_mutasi_dtl.`no_aju`,
        beacukai_mutasi_dtl.item,tb_kode_fg.`kode_item`,tb_kode_fg.`nama_item`,item_ccn.`item_description`,
        tb_kode_fg.satuan,SUM(IF(tb_kode_fg.`nama_item`='PPMF',beacukai_mutasi_dtl.`kg`,namaqty.totalqty)) AS alltotalqty, 
        SUM(beacukai_mutasi_dtl.`kg`) AS kgm ,beacukai_mutasi_hdr.urut,beacukai_mutasi_hdr.kode2
        FROM beacukai_mutasi_hdr
        JOIN beacukai_mutasi_dtl ON beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode
        LEFT JOIN (SELECT rec_hdr_freight_bill AS noaju, item_description AS desk FROM rech_hdr 
LEFT JOIN rec_hist ON rec_hist.`receiver`=rech_hdr.`receiver`
LEFT JOIN item_ccn_kite ON item_ccn_kite.item=rec_hist.rec_item
WHERE  klp_beacukai='FK' AND rec_hdr_freight_bill NOT IN 
('004505','004573','202111','201895','000312','201891','202105','004494','004488') AND tgl_beacukai>'2022-09-01'
GROUP BY rec_hdr_freight_bill) AS najui ON najui.noaju=beacukai_mutasi_dtl.`no_aju`
        JOIN item_ccn ON item_ccn.item=beacukai_mutasi_dtl.`item`
        LEFT JOIN tb_kode_fg ON tb_kode_fg.`kode_bb`=item_ccn.`hpl`
        LEFT JOIN (SELECT beacukai_mutasi_hdr.kode,tgl,beacukai_mutasi_dtl.`no_aju`,beacukai_mutasi_dtl.item,kode_item,nama_item,item_description,tb_kode_fg.satuan,IF(nama_item='PPMF',SUM(kg),SUM(qty)) AS totalqty
                                FROM beacukai_mutasi_dtl
                                JOIN beacukai_mutasi_hdr ON beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode
                                JOIN item_ccn ON item_ccn.item=beacukai_mutasi_dtl.`item`
                                LEFT JOIN tb_kode_fg ON tb_kode_fg.`kode_bb`=item_ccn.`hpl` WHERE  (deleted_at is null or deleted_at='0000-00-00 00:00:00') AND IF(beacukai_mutasi_hdr.`lokasi_tujuan` ='GDBFTK',beacukai_mutasi_dtl.`code`='1',beacukai_mutasi_dtl.`code` LIKE '%') AND
                                CONCAT(beacukai_mutasi_hdr.kode2,'/',IFNULL(item_ccn.`hpl`,'')) LIKE '$data%' GROUP BY beacukai_mutasi_dtl.`item`) AS namaqty ON namaqty.item=beacukai_mutasi_dtl.item
        WHERE (deleted_at IS NULL OR deleted_at='0000-00-00 00:00:00')
        AND CONCAT(beacukai_mutasi_hdr.kode2,'/',IFNULL(item_ccn.`hpl`,'')) LIKE '$data%'
        AND no_aju <> 0
        GROUP BY beacukai_mutasi_dtl.`item`,beacukai_mutasi_dtl.`no_aju`")
            ->getResultArray();

        foreach ($item as $i) {
        }
    }

    public function Namattd($data)
    {
        return $this->db->query("SELECT kodemutasi,dkm,dkym,dim,dipm FROM beacukai_ttdmutasi
        WHERE kodemutasi IN (SELECT CONCAT(analyst_asal,'/',analyst_tujuan) FROM beacukai_mutasi_hdr WHERE beacukai_mutasi_hdr.kode2 LIKE CONCAT(LEFT('$data',16),'%'))")
            ->getRowArray();
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
        return $this->hd->insert([
            'kode' => $data['kode'],
            'tgl' => $data['tgl'],
            'lokasi_asal' => $data['lokasi_asal'],
            'lokasi_tujuan' => $data['lokasi_tujuan'],
            'analyst_asal' => $data['analyst_asal'],
            'analyst_tujuan' => $data['analyst_tujuan'],
            'kode2' => $data['kode2'],
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
    public function Allitemserver($data)
    {
        return $this->db->query("SELECT item_ccn.`item` AS item,item_description,IF(dtl.`itemdtl` IS NULL,'(Belum Pernah Dipakai di mutasi produksi)','') AS status FROM item_ccn LEFT JOIN (SELECT item AS itemdtl FROM beacukai_mutasi_dtl GROUP BY item) AS dtl ON item_ccn.item=dtl.itemdtl WHERE item_description LIKE '%$data%' OR item_ccn.`item` LIKE '%$data%' ORDER BY dtl.`itemdtl` DESC LIMIT 10")
            ->getResultArray();
    }
    public function Allanalyst()
    {
        return $this->db->query("SELECT analyst_code,analyst_name,analyst FROM beacukai_analyst")
            ->getResultArray();
    }
    public function Kodelok($data)
    {
        return $this->db->query("SELECT Analyst FROM beacukai_analyst WHERE analyst_code='$data'")
            ->getRowArray();
    }
    public function Kodelok2($data)
    {
        return $this->db->query("SELECT analyst_code FROM beacukai_analyst WHERE analyst='$data'")
            ->getRowArray();
    }

    public function Kodechecklist($data)
    {
        return $this->db->query("SELECT beacukai_mutasi_hdr.kode,beacukai_mutasi_hdr.kode2,CONCAT(beacukai_mutasi_hdr.`analyst_asal`,'/',beacukai_mutasi_hdr.`analyst_tujuan`) AS kodemutasi,lokasi_asal,lokasi_tujuan,analyst_asal,analyst_tujuan,beacukai_mutasi_hdr.`tgl`,beacukai_mutasi_dtl.`sec`,no_aju,beacukai_mutasi_dtl.item,beacukai_mutasi_dtl.code, beacukai_mutasi_dtl.`kg` AS kgm,beacukai_mutasi_dtl.`iduser` AS USER, beacukai_mutasi_dtl.`updated_at`
FROM beacukai_mutasi_dtl
JOIN beacukai_mutasi_hdr ON beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode
WHERE beacukai_mutasi_dtl.`sec`='$data'")
            ->getRowArray();
    }

    public function Nomaxhdr($data)
    {
        return $this->db->query("SELECT MAX(ROUND(REPLACE(LEFT(kode2, 2),'/~',''),0)) AS maxno FROM beacukai_mutasi_hdr WHERE kode LIKE '%" . $data['bulantahun'] . "' AND analyst_asal='" . $data['lokasal'] . "'")
            ->getRowArray();
    }

    public function Ceksurat($data)
    {
        return $this->db->query("SELECT * FROM beacukai_mutasi_hdr WHERE kode='$data'")
            ->getNumRows();
    }

    public function Ceksuratbon($data)
    {
        return $this->db->query("SELECT * FROM beacukai_mutasi_hdr WHERE kode like '%" . $data['bulantahun'] . "' AND analyst_asal='" . $data['lokasal'] . "'")
            ->getNumRows();
    }

    public function Edit($data)
    {
        return $this->dt->select("sec,no_aju,code,beacukai_mutasi_dtl.item,beacukai_mutasi_dtl.`qty` AS alltotalqty, beacukai_mutasi_dtl.`kg` AS kgm")
            ->join('beacukai_mutasi_hdr', 'beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode')
            ->where('beacukai_mutasi_dtl.`sec`', $data)
            ->get()->getRowArray();
    }

    public function Editm($data)
    {
        return $this->dt->select("sec,beacukai_mutasi_hdr.`lokasi_asal`,asal, beacukai_mutasi_hdr.`lokasi_tujuan`,tujuan,tgl")
            ->join('beacukai_mutasi_hdr', 'beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode')
            ->join('(select analyst,analyst_name as asal from beacukai_analyst) as asl', 'asl.analyst=beacukai_mutasi_hdr.lokasi_asal', 'left')
            ->join('(select analyst,analyst_name as tujuan from beacukai_analyst) as tjn', 'tjn.analyst=beacukai_mutasi_hdr.lokasi_tujuan', 'left')
            ->where('beacukai_mutasi_dtl.`sec`', $data)
            ->get()->getRowArray();
    }

    public function Editi($data)
    {
        return $this->dt->select("sec,beacukai_mutasi_dtl.item,item_ccn.`item_description`")
            ->join('item_ccn', 'item_ccn.item=beacukai_mutasi_dtl.`item`')
            ->where('beacukai_mutasi_dtl.`sec`', $data)
            ->get()->getRowArray();
    }

    public function _get_datatables_querymutasiproduksi($data)
    {
        $column_order = array("beacukai_mutasi_hdr.kode2", "beacukai_mutasi_hdr.kode2", 'beacukai_mutasi_hdr.`tgl`', 'no_aju', 'beacukai_mutasi_dtl.item', 'asl.asal', 'tb_kode_fg.`nama_item`', 'item_ccn.`item_description`', 'beacukai_mutasi_dtl.`qty`', 'beacukai_mutasi_dtl.`kg`', 'beacukai_mutasi_dtl.`iduser`', 'beacukai_mutasi_dtl.`updated_at`', 'beacukai_mutasi_dtl.`updated_at`');
        $column_search = array("beacukai_mutasi_hdr.kode2", "beacukai_mutasi_hdr.kode2", 'beacukai_mutasi_hdr.`tgl`', 'no_aju', 'beacukai_mutasi_dtl.item', 'asl.asal', 'tb_kode_fg.`nama_item`', 'item_ccn.`item_description`', 'beacukai_mutasi_dtl.`qty`', 'beacukai_mutasi_dtl.`kg`', 'beacukai_mutasi_dtl.`iduser`', 'beacukai_mutasi_dtl.`updated_at`', 'beacukai_mutasi_dtl.`updated_at`');
        $order = array('beacukai_mutasi_dtl.`updated_at`' => 'desc');

        //         SELECT beacukai_mutasi_hdr.kode,beacukai_mutasi_hdr.`tgl`,no_aju,beacukai_mutasi_dtl.item,tb_kode_fg.`kode_item`,tb_kode_fg.`nama_item`,item_ccn.`item_description`,tb_kode_fg.satuan,IF(tb_kode_fg.`nama_item`='PPMF',beacukai_mutasi_dtl.`kg`,beacukai_mutasi_dtl.`qty`) AS alltotalqty, beacukai_mutasi_dtl.`kg` AS kgm 
        // FROM beacukai_mutasi_dtl
        // JOIN beacukai_mutasi_hdr ON beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode
        // JOIN item_ccn ON item_ccn.item=beacukai_mutasi_dtl.`item`
        // JOIN tb_kode_fg ON tb_kode_fg.`kode_bb`=item_ccn.`hpl`
        // WHERE  beacukai_mutasi_hdr.`lokasi_tujuan` ='GDBFTK' AND
        // beacukai_mutasi_hdr.`tgl` BETWEEN '" . $fnama . "' AND '" . $fnama2 . "'

        $this->dt->select("beacukai_mutasi_hdr.kode,beacukai_mutasi_hdr.kode2,CONCAT(beacukai_mutasi_hdr.`analyst_asal`,'/',beacukai_mutasi_hdr.`analyst_tujuan`) AS kodemutasi,item_ccn.`hpl` AS hpl,beacukai_mutasi_hdr.`tgl`,beacukai_mutasi_dtl.`sec`,no_aju,beacukai_mutasi_dtl.item,beacukai_mutasi_dtl.code,asal,tb_kode_fg.`nama_item`,item_ccn.`item_description`,IF(tb_kode_fg.`nama_item`='PPMF',beacukai_mutasi_dtl.`kg`,beacukai_mutasi_dtl.`qty`) AS alltotalqty, beacukai_mutasi_dtl.`kg` AS kgm,beacukai_mutasi_dtl.`iduser` AS user, beacukai_mutasi_dtl.`updated_at`");
        $this->dt->join('beacukai_mutasi_hdr', 'beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode');
        $this->dt->join('item_ccn', 'item_ccn.item=beacukai_mutasi_dtl.`item`');
        $this->dt->join('(select analyst,analyst_name as asal from beacukai_analyst) as asl', 'asl.analyst=beacukai_mutasi_hdr.lokasi_asal', 'left');
        $this->dt->join('(select analyst,analyst_name as tujuan from beacukai_analyst) as tjn', 'tjn.analyst=beacukai_mutasi_hdr.lokasi_tujuan', 'left');
        $this->dt->join('tb_kode_fg', 'tb_kode_fg.`kode_bb`=item_ccn.`hpl`', 'left');
        $this->dt->like('beacukai_mutasi_hdr.`analyst_asal`', $data['pilihasal']);
        $this->dt->like('beacukai_mutasi_hdr.`analyst_tujuan`', $data['pilihtujuan']);
        $this->dt->like('beacukai_mutasi_dtl.item', $data['itemfilter']);
        if ($data['tgldari'] != '') {
            $this->dt->where('beacukai_mutasi_hdr.`tgl`>=', $data['tgldari']);
        }
        if ($data['tglke'] != '') {
            $this->dt->where('beacukai_mutasi_hdr.`tgl`<=', $data['tglke']);
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

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesmutasiproduksi($data)
    {
        $this->_get_datatables_querymutasiproduksi($data);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredmutasiproduksi($data)
    {
        $this->_get_datatables_querymutasiproduksi($data);
        return $this->dt->countAllResults();
    }

    public function count_allmutasiproduksi()
    {
        return $this->select("beacukai_mutasi_hdr.kode,beacukai_mutasi_hdr.`tgl`,no_aju,beacukai_mutasi_dtl.item,tb_kode_fg.`nama_item`,item_ccn.`item_description`,IF(tb_kode_fg.`nama_item`='PPMF',beacukai_mutasi_dtl.`kg`,beacukai_mutasi_dtl.`qty`) AS alltotalqty, beacukai_mutasi_dtl.`kg` AS kgm, beacukai_mutasi_dtl.`updated_at`")
            ->join('beacukai_mutasi_hdr', 'beacukai_mutasi_dtl.kode=beacukai_mutasi_hdr.kode')
            ->join('item_ccn', 'item_ccn.item=beacukai_mutasi_dtl.`item`')
            ->join('(select analyst,analyst_name as asal from beacukai_analyst) as asl', 'asl.analyst=beacukai_mutasi_hdr.lokasi_asal', 'left')
            ->join('(select analyst,analyst_name as asal from beacukai_analyst) as tjn', 'tjn.analyst=beacukai_mutasi_hdr.lokasi_tujuan', 'left')
            ->join('tb_kode_fg', 'tb_kode_fg.`kode_bb`=item_ccn.`hpl`', 'left')
            ->countAllResults();
    }
}