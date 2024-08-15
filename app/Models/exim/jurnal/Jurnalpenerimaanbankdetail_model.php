<?php

namespace App\Models\exim\jurnal;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Jurnalpenerimaanbankdetail_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'beacukai_jurnal_penerimaanbank_detail';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'kode', 'kode_bank', 'tgl', 'biayabank', 'kgm_peb', 'nilai_peb', 'kgm_pib', 'nilai_pib', 'debit', 'kredit', 'mu', 'kurs', 'beacukai_jurnal_penjualan_id', 'id_jurnal_penerimaanbank'];

    protected $request;
    protected $dt;
    protected $rh;
    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('beacukai_jurnal_penerimaanbank');
        // $this->rh = $this->db->table('beacukai_jurnal_penerimaanbank');
        $this->request = $request;
    }

    public function Bank()
    {
        return $this->db->query("SELECT * FROM ms_bank")
            ->getResultArray();
    }

    public function Inv()
    {
        return $this->db->query("SELECT beacukai_jurnal_penjualan.`inv`, beacukai_jurnal_penjualan.`kgm` FROM beacukai_jurnal_penjualan
        WHERE CONCAT(' ', beacukai_jurnal_penjualan.`inv`, beacukai_jurnal_penjualan.`kgm`) NOT IN
(SELECT CONCAT(' ' ,Inv, kgm_peb) FROM beacukai_jurnal_penerimaanbank JOIN beacukai_jurnal_penerimaanbank_detail ON beacukai_jurnal_penerimaanbank.`kode`=beacukai_jurnal_penerimaanbank_detail.`kode`)
ORDER BY beacukai_jurnal_penjualan.`inv` ASC")
            ->getResultArray();
    }

    public function Aju()
    {
        return $this->db->query("SELECT beacukai_jurnal_pembelian.`aju`, beacukai_jurnal_pembelian.`kgm` FROM beacukai_jurnal_pembelian
        WHERE beacukai_jurnal_pembelian.`aju` NOT IN (SELECT aju
        FROM beacukai_jurnal_penerimaanbank) AND beacukai_jurnal_pembelian.`kgm`
        NOT IN (SELECT kgm_pib FROM beacukai_jurnal_penerimaanbank_detail) ORDER BY beacukai_jurnal_pembelian.`aju`")
            ->getResultArray();
    }
    public function Searchdatafrominv($data)
    {
        return $this->db->query("SELECT peb, kgm, tglpeb, inv, cus, nilai FROM beacukai_jurnal_penjualan WHERE inv='$data'")
            ->getResultArray();
    }
    public function Searchdatafromaju($data)
    {
        return $this->db->query("SELECT aju, tglbapb, kgm, nilai FROM beacukai_jurnal_pembelian WHERE aju='$data'")
            ->getResultArray();
    }
    public function Codedb($data)
    {
        return $this->db->query("SELECT RIGHT(kode, 12)AS kode, MID(kode, 9,4), MID(kode, 14, 2) FROM beacukai_jurnal_penerimaanbank WHERE MID(kode, 9,4)='" . $data['tahun'] . "' AND MID(kode, 14, 2)='" . $data['bulan'] . "'")
            ->getNumRows();
    }

    public function Codedb2($data)
    {
        return $this->db->query("SELECT MAX(RIGHT(kode, 3)) AS kode FROM beacukai_jurnal_penerimaanbank WHERE MID(kode, 9,4)='" . $data['tahun'] . "' AND MID(kode, 14, 2)='" . $data['bulan'] . "'")
            ->getRowArray();
    }

    public function Edit($data)
    {
        return $this->select("kode,kode_bank,tgl,biayabank,kgm_peb,nilai_peb,kgm_pib,nilai_pib,debit,kredit,mu,kurs,beacukai_jurnal_penjualan_id,id_jurnal_penerimaanbank")
            ->where('kode', $data)
            ->get()->getResultArray();
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

    public function _get_datatables_queryjurnalpenerimaanbank($data)
    {
        $column_order = array('kode', 'kode', 'ms_bank.`nama`', 'beacukai_jurnal_penerimaanbank.`tgl`', 'beacukai_jurnal_penerimaanbank.`peb`', 'biayabank', 'beacukai_jurnal_penerimaanbank.`tgl_peb`', 'inv', 'customer', 'nilai', 'mu', 'kurs', 'updated_at', 'updated_at');
        $column_search = array('kode', 'kode', 'ms_bank.`nama`', 'beacukai_jurnal_penerimaanbank.`tgl`', 'beacukai_jurnal_penerimaanbank.`peb`', 'biayabank', 'beacukai_jurnal_penerimaanbank.`tgl_peb`', 'inv', 'customer', 'nilai', 'mu', 'kurs', 'updated_at', 'updated_at');
        $order = array('beacukai_jurnal_penerimaanbank.`tgl`' => 'DESC');

        $this->dt->select("kode, ms_bank.`nama` AS namabank, beacukai_jurnal_penerimaanbank.`tgl` AS tgl, beacukai_jurnal_penerimaanbank.`peb` AS peb,biayabank, beacukai_jurnal_penerimaanbank.`tgl_peb` AS tgl_peb, inv, customer AS pelanggan, nilai, mu, kurs,updated_at");
        $this->dt->join('ms_bank', 'ms_bank.`kode_bank`=beacukai_jurnal_penerimaanbank.`kode_bank`', 'left');
        if ($data['tgldari'] != '') {
            $this->dt->where('beacukai_jurnal_penerimaanbank.`tgl`>=', $data['tgldari']);
        }
        if ($data['tglke'] != '') {
            $this->dt->where('beacukai_jurnal_penerimaanbank.`tgl`<=', $data['tglke']);
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

    public function get_datatablesjurnalpenerimaanbank($data)
    {
        $this->_get_datatables_queryjurnalpenerimaanbank($data);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredjurnalpenerimaanbank($data)
    {
        $this->_get_datatables_queryjurnalpenerimaanbank($data);
        return $this->dt->countAllResults();
    }

    public function count_alljurnalpenerimaanbank()
    {
        return $this->dt->select("kode, ms_bank.`nama` AS namabank, beacukai_jurnal_penerimaanbank.`tgl` AS tgl, beacukai_jurnal_penerimaanbank.`peb` AS peb,biayabank, beacukai_jurnal_penerimaanbank.`tgl_peb` AS tgl_peb, inv, customer AS pelanggan, nilai, mu, kurs")
            ->join('ms_bank', 'ms_bank.`kode_bank`=beacukai_jurnal_penerimaanbank.`kode_bank`', 'left')
            ->countAllResults();
    }
}
