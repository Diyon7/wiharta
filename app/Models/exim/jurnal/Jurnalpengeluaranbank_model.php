<?php

namespace App\Models\exim\jurnal;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Jurnalpengeluaranbank_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'beacukai_jurnal_pengeluaranbank';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'kode', 'kode_bank', 'kode_referensi', 'aju', 'bapb', 'tgl_bapb', 'tgl', 'supplier', 'nilai', 'mu', 'kurs', 'biayabank', 'biayaasuransi', 'biayatransport', 'nilai2', 'inv', 'beacukai_jurnal_pembelian_id', 'created_at', 'updated_at', 'user'];

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
        $this->dt = $this->db->table('beacukai_jurnal_pengeluaranbank');
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
        return $this->db->query("SELECT beacukai_jurnal_penjualan.`inv`, SUM(beacukai_jurnal_penjualan.`nilai`) AS kgm FROM beacukai_jurnal_penjualan
        WHERE CONCAT(' ', beacukai_jurnal_penjualan.`inv`, beacukai_jurnal_penjualan.`nilai`) NOT IN
        (SELECT CONCAT(' ' ,IFNULL(inv,''), IFNULL(nilai_peb,0)) FROM beacukai_jurnal_pengeluaranbank JOIN beacukai_jurnal_pengeluaranbank_detail ON beacukai_jurnal_pengeluaranbank.`kode`=beacukai_jurnal_pengeluaranbank_detail.`kode`)
        AND beacukai_jurnal_penjualan.`tglpeb`>'2023-02-28' GROUP BY inv ORDER BY beacukai_jurnal_penjualan.`inv` ASC")
            ->getResultArray();
    }


    public function Aju()
    {
        return $this->db->query("SELECT beacukai_jurnal_pembelian.`aju` FROM beacukai_jurnal_pembelian
        WHERE beacukai_jurnal_pembelian.`aju` NOT IN (SELECT aju FROM beacukai_jurnal_pengeluaranbank) GROUP BY beacukai_jurnal_pembelian.`aju` ORDER BY beacukai_jurnal_pembelian.`aju`")
            ->getResultArray();
    }
    public function Searchdatafrominv($data)
    {
        return $this->db->query("SELECT peb, kgm, tglpeb, inv, cus, nilai FROM beacukai_jurnal_penjualan WHERE inv='$data'")
            ->getResultArray();
    }
    public function Searchdatafromaju($data)
    {
        return $this->db->query("SELECT aju, bapb, tglbapb, vendor, nilai FROM beacukai_jurnal_pembelian WHERE aju='$data'")
            ->getResultArray();
    }
    public function Codedb($data)
    {
        return $this->db->query("SELECT RIGHT(kode, 12)AS kode, MID(kode, 9,4), MID(kode, 14, 2) FROM beacukai_jurnal_pengeluaranbank WHERE MID(kode, 9,4)='" . $data['tahun'] . "' AND MID(kode, 14, 2)='" . $data['bulan'] . "'")

            ->getNumRows();
    }

    public function Codedb2($data)
    {
        return $this->db->query("SELECT MAX(RIGHT(kode, 3)) AS kode FROM beacukai_jurnal_pengeluaranbank WHERE MID(kode, 9,4)='" . $data['tahun'] . "' AND MID(kode, 14, 2)='" . $data['bulan'] . "'")

            ->getRowArray();
    }

    public function Edit($data)
    {
        return $this->select("kode,beacukai_jurnal_pengeluaranbank.`kode_bank`,inv,nama,kode_referensi,biayabank,biayaasuransi,biayatransport,nilai2,aju,tgl,bapb,tgl_bapb,supplier,nilai")
            ->join("ms_bank", "beacukai_jurnal_pengeluaranbank.`kode_bank`=ms_bank.`kode_bank`")
            ->where("kode", $data)
            ->get()->getRowArray();
    }

    public function Cetakkode($data)
    {
        return $this->db->query("SELECT beacukai_jurnal_pengeluaranbank.`kode`,beacukai_jurnal_pengeluaranbank.`biayatransport`,beacukai_jurnal_pengeluaranbank.`biayaasuransi`,beacukai_jurnal_pengeluaranbank.`biayabank`,beacukai_jurnal_pengeluaranbank.`kode_bank`, beacukai_jurnal_pengeluaranbank.`aju`, beacukai_jurnal_pengeluaranbank_detail.`tgl`, beacukai_jurnal_pengeluaranbank.`supplier`, beacukai_jurnal_pengeluaranbank.`nilai`, beacukai_jurnal_pengeluaranbank.`mu`, beacukai_jurnal_pengeluaranbank.`kurs`, beacukai_jurnal_pengeluaranbank.`kurs`,beacukai_jurnal_pengeluaranbank_detail.`kredit`, beacukai_jurnal_pengeluaranbank_detail.`debit` FROM beacukai_jurnal_pengeluaranbank RIGHT JOIN beacukai_jurnal_pengeluaranbank_detail ON beacukai_jurnal_pengeluaranbank.`kode`=beacukai_jurnal_pengeluaranbank_detail.`kode` where beacukai_jurnal_pengeluaranbank.kode='$data'")->getResultArray();
    }

    public function Ceksurat($data)
    {
        return $this->db->query("SELECT * FROM beacukai_mutasi_hdr WHERE kode='$data'")
            ->getNumRows();
    }

    public function _get_datatables_queryjurnalpengeluaranbank($data)
    {
        $column_order = array('beacukai_jurnal_pengeluaranbank.kode', 'ms_bank.`nama`', 'beacukai_jurnal_pengeluaranbank.`tgl`', 'beacukai_jurnal_pengeluaranbank.`aju`', 'bapb', 'tgl_bapb', 'supplier', 'selisih', 'updated_at', 'updated_at');
        $column_search = array('beacukai_jurnal_pengeluaranbank.kode', 'ms_bank.`nama`', 'beacukai_jurnal_pengeluaranbank.`tgl`', 'beacukai_jurnal_pengeluaranbank.`aju`', 'bapb', 'tgl_bapb', 'supplier', 'supplier', 'updated_at', 'updated_at');
        $order = array('beacukai_jurnal_pengeluaranbank.`tgl`' => 'DESC');

        $this->dt->select("beacukai_jurnal_pengeluaranbank.kode, ms_bank.`nama` AS namabank, beacukai_jurnal_pengeluaranbank.`tgl` AS tgl, beacukai_jurnal_pengeluaranbank.`aju` AS aju,bapb,tgl_bapb, supplier, SUM(beacukai_jurnal_pengeluaranbank_detail.nilai) AS nilai,(SUM(kredit)+biayabank+biayaasuransi+biayatransport)-SUM(debit) AS selisih,updated_at");
        $this->dt->join("beacukai_jurnal_pengeluaranbank_detail", "beacukai_jurnal_pengeluaranbank.`kode`=beacukai_jurnal_pengeluaranbank_detail.`kode`", "left");
        $this->dt->join('ms_bank', 'ms_bank.`kode_bank`=beacukai_jurnal_pengeluaranbank.`kode_bank`', 'left');
        if ($data['tgldari'] != '') {
            $this->dt->where('beacukai_jurnal_pengeluaranbank.`tgl`>=', $data['tgldari']);
        }
        if ($data['tglke'] != '') {
            $this->dt->where('beacukai_jurnal_pengeluaranbank.`tgl`<=', $data['tglke']);
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

        $this->dt->groupBy("beacukai_jurnal_pengeluaranbank.kode");

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablesjurnalpengeluaranbank($data)
    {
        $this->_get_datatables_queryjurnalpengeluaranbank($data);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredjurnalpengeluaranbank($data)
    {
        $this->_get_datatables_queryjurnalpengeluaranbank($data);
        return $this->dt->countAllResults();
    }

    public function count_alljurnalpengeluaranbank()
    {
        return $this->dt->select("kode")
            ->countAllResults();
    }
}