<?php

namespace App\Models\exim\jurnal;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Jurnalpenjualan_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'beacukai_jurnal_penjualan';
    protected $primaryKey = 'id';

    protected $allowedFields = ['seq', 'id', 'bpb', 'tglbpb', 'peb', 'tglpeb', 'inv', 'cus', 'item', 'satuan', 'qty', 'kgm', 'nilai', 'no_spp', 'mu', 'user_id', 'created_at', 'updated_at'];

    protected $request;
    protected $dt;
    protected $rh;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('beacukai_jurnal_penjualan');
        $this->rh = $this->db->table('tb_pengeluaran');
        $this->request = $request;
    }

    public function Aju()
    {
        return $this->db->query("SELECT rec_hdr_freight_bill as aju FROM rech_hdr where rec_hdr_freight_bill NOT LIKE '%-%' AND (tgl_beacukai BETWEEN '2022-01-01' AND CURDATE()) GROUP BY rec_hdr_freight_bill ORDER BY rec_hdr_freight_bill")
            ->getResultArray();
    }

    public function Allitem()
    {
        return $this->db->query("SELECT beacukai_mutasi_dtl.item,item_description from beacukai_mutasi_dtl join item_ccn on item_ccn.item=beacukai_mutasi_dtl.item group by beacukai_mutasi_dtl.item")
            ->getResultArray();
    }

    public function Edit($data)
    {
        return $this->db->query("SELECT id,kurs FROM beacukai_jurnal_penjualan_detail WHERE id='$data'")
            ->getRowArray();
    }

    public function Jurnalpenjualanedit($data)
    {
        return $this->rh->select("tb_pengeluaran.`seq`,nobpb,tgbpb,nopeb,tgpeb,tb_pengeluaran.`inv`,namacus,kodeitem,desk,tb_pengeluaran.`satuan`,tb_pengeluaran.`nospp`,tb_pengeluaran.`qty`,tb_pengeluaran.`kgm`,fob,kurs,tb_pengeluaran.`mu`")
            ->join('beacukai_jurnal_penjualan', 'beacukai_jurnal_penjualan.`peb`=tb_pengeluaran.`nopeb` AND beacukai_jurnal_penjualan.`item`=tb_pengeluaran.`kodeitem` AND beacukai_jurnal_penjualan.`nilai`=tb_pengeluaran.`fob`', 'left')
            ->join('beacukai_jurnal_penjualan_detail', 'beacukai_jurnal_penjualan_detail.`id`=beacukai_jurnal_penjualan.`id`', 'left')
            ->where('tb_pengeluaran.`seq`', $data)
            ->get()->getRowArray();
    }

    public function Cetakperiode($data)
    {
        return $this->db->query("select * from beacukai_jurnal_penjualan_detail where tgl BETWEEN '" . $data['tgldari'] . "' and '" . $data['tglke'] . "'")->getResultArray();
    }

    public function Cetakkode($data)
    {
        return $this->db->query("select * from beacukai_jurnal_penjualan_detail where id='$data'")->getResultArray();
    }

    public function Ceksurat($data)
    {
        return $this->db->query("SELECT * FROM beacukai_mutasi_hdr WHERE kode='$data'")
            ->getNumRows();
    }

    public function Idmaxjurnalpenjualan()
    {
        return $this->db->query("SELECT (MAX(id)+1) AS bjpmaxid FROM beacukai_jurnal_penjualan")
            ->getRowArray();
    }

    public function _get_datatables_querysemuajurnalpenjualan($data)
    {
        $column_order = array('nobpb', 'nobpb', 'tgbpb', 'nopeb', 'tgpeb', 'tb_pengeluaran.`inv`', 'namacus', 'kodeitem', 'desk', 'tb_pengeluaran.`satuan`', 'tb_pengeluaran.`qty`', 'tb_pengeluaran.`kgm`', 'fob', 'tb_pengeluaran.`mu`', 'beacukai_jurnal_penjualan_detail.kurs', 'beacukai_jurnal_penjualan.`updated_at`', 'beacukai_jurnal_penjualan.`updated_at`');
        $column_search = array('nobpb', 'nobpb', 'tgbpb', 'nopeb', 'tgpeb', 'tb_pengeluaran.`inv`', 'namacus', 'kodeitem', 'desk', 'tb_pengeluaran.`satuan`', 'tb_pengeluaran.`qty`', 'tb_pengeluaran.`kgm`', 'fob', 'tb_pengeluaran.`mu`', 'beacukai_jurnal_penjualan_detail.kurs', 'beacukai_jurnal_penjualan.`updated_at`', 'beacukai_jurnal_penjualan.`updated_at`');
        $order = array('beacukai_jurnal_penjualan_detail.kurs' => 'ASC');

        $this->rh->select("tb_pengeluaran.`seq`,beacukai_jurnal_penjualan_detail.kurs,beacukai_jurnal_penjualan.`id`,beacukai_jurnal_penjualan_detail.`id` as iddetail,nobpb,tgbpb,nopeb,tgpeb,tb_pengeluaran.`inv`,namacus,kodeitem,desk,tb_pengeluaran.`satuan`,tb_pengeluaran.`qty`,tb_pengeluaran.`kgm`,fob,tb_pengeluaran.`mu`,beacukai_jurnal_penjualan.`updated_at`");
        $this->rh->join('beacukai_jurnal_penjualan', 'beacukai_jurnal_penjualan.`peb`=tb_pengeluaran.`nopeb` AND beacukai_jurnal_penjualan.`item`=tb_pengeluaran.`kodeitem` AND beacukai_jurnal_penjualan.`nilai`=tb_pengeluaran.`fob`', 'left');
        $this->rh->join('beacukai_jurnal_penjualan_detail', 'beacukai_jurnal_penjualan_detail.`id`=beacukai_jurnal_penjualan.`id`', 'left');
        $this->rh->where('tgpeb>', '2023-02-28');
        if ($data['tgldari'] != '') {
            $this->rh->where('tgpeb>=', $data['tgldari']);
        }
        if ($data['tglke'] != '') {
            $this->rh->where('tgpeb<=', $data['tglke']);
        }

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->rh->groupStart();
                    $this->rh->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->rh->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->rh->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->rh->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->rh->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablessemuajurnalpenjualan($data)
    {
        $this->_get_datatables_querysemuajurnalpenjualan($data);
        if ($this->request->getPost('length') != -1)
            $this->rh->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->rh->get();
        return $query->getResult();
    }

    public function count_filteredsemuajurnalpenjualan($data)
    {
        $this->_get_datatables_querysemuajurnalpenjualan($data);
        return $this->rh->countAllResults();
    }

    public function count_allsemuajurnalpenjualan()
    {
        return $this->rh->select("id,nobpb,tgbpb,nopeb,tgpeb,tb_pengeluaran.`inv`,namacus,kodeitem,desk,tb_pengeluaran.`satuan`,tb_pengeluaran.`qty`,tb_pengeluaran.`kgm`,fob,tb_pengeluaran.`mu`,beacukai_jurnal_penjualan.`updated_at`")
            ->join('beacukai_jurnal_penjualan', 'beacukai_jurnal_penjualan.`peb`=tb_pengeluaran.`nopeb` AND beacukai_jurnal_penjualan.`item`=tb_pengeluaran.`kodeitem` AND beacukai_jurnal_penjualan.`nilai`=tb_pengeluaran.`fob`', 'left')
            ->where('tgpeb>', '2023-02-28')
            ->countAllResults();
    }

    public function _get_datatables_querybelumjurnalpenjualan()
    {
        $column_order = array('nobpb', 'nobpb', 'tgbpb', 'nopeb', 'tgpeb', 'tb_pengeluaran.`inv`', 'namacus', 'kodeitem', 'desk', 'tb_pengeluaran.`satuan`', 'tb_pengeluaran.`qty`', 'tb_pengeluaran.`kgm`', 'fob', 'tb_pengeluaran.`mu`', 'beacukai_jurnal_penjualan.`updated_at`', 'beacukai_jurnal_penjualan.`updated_at`');
        $column_search = array('nobpb', 'nobpb', 'tgbpb', 'nopeb', 'tgpeb', 'tb_pengeluaran.`inv`', 'namacus', 'kodeitem', 'desk', 'tb_pengeluaran.`satuan`', 'tb_pengeluaran.`qty`', 'tb_pengeluaran.`kgm`', 'fob', 'tb_pengeluaran.`mu`', 'beacukai_jurnal_penjualan.`updated_at`', 'beacukai_jurnal_penjualan.`updated_at`');
        $order = array('tgpeb' => 'DESC');

        $this->rh->select("tb_pengeluaran.`seq`,beacukai_jurnal_penjualan.`id`,beacukai_jurnal_penjualan_detail.`id`,nobpb,tgbpb,nopeb,tgpeb,tb_pengeluaran.`inv`,namacus,kodeitem,desk,tb_pengeluaran.`satuan`,tb_pengeluaran.`qty`,tb_pengeluaran.`kgm`,fob,tb_pengeluaran.`mu`,beacukai_jurnal_penjualan.`updated_at`");
        $this->rh->join('beacukai_jurnal_penjualan', 'beacukai_jurnal_penjualan.`peb`=tb_pengeluaran.`nopeb` AND beacukai_jurnal_penjualan.`item`=tb_pengeluaran.`kodeitem` AND beacukai_jurnal_penjualan.`nilai`=tb_pengeluaran.`fob` AND beacukai_jurnal_penjualan.`no_spp`=tb_pengeluaran.`nospp`', 'left');
        $this->rh->join('beacukai_jurnal_penjualan_detail', 'beacukai_jurnal_penjualan_detail.`id`=beacukai_jurnal_penjualan.`id`', 'left');
        $this->rh->where('beacukai_jurnal_penjualan.`id` IS NULL');
        $this->rh->where('tgpeb>', '2023-02-28');

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->rh->groupStart();
                    $this->rh->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->rh->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->rh->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->rh->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->rh->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesbelumjurnalpenjualan()
    {
        $this->_get_datatables_querybelumjurnalpenjualan();
        if ($this->request->getPost('length') != -1)
            $this->rh->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->rh->get();
        return $query->getResult();
    }

    public function count_filteredbelumjurnalpenjualan()
    {
        $this->_get_datatables_querybelumjurnalpenjualan();
        return $this->rh->countAllResults();
    }

    public function count_allbelumjurnalpenjualan()
    {
        return $this->rh->select("id,nobpb,tgbpb,nopeb,tgpeb,tb_pengeluaran.`inv`,namacus,kodeitem,desk,tb_pengeluaran.`satuan`,tb_pengeluaran.`qty`,tb_pengeluaran.`kgm`,fob,tb_pengeluaran.`mu`,beacukai_jurnal_penjualan.`updated_at`")
            ->join('beacukai_jurnal_penjualan', 'beacukai_jurnal_penjualan.`peb`=tb_pengeluaran.`nopeb` AND beacukai_jurnal_penjualan.`item`=tb_pengeluaran.`kodeitem` AND beacukai_jurnal_penjualan.`nilai`=tb_pengeluaran.`fob`', 'left')
            ->where('beacukai_jurnal_penjualan.`id` IS NULL')
            ->where('tgpeb>', '2023-02-28')
            ->countAllResults();
    }
}