<?php

namespace App\Models\exim\export;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Pengeluaran_model extends Model
{
    protected $DBGroup = 'thirddb';
    protected $table      = 'invoice_dokumen_new';
    // protected $primaryKey = 'sec';

    protected $allowedFields = ['kode', 'negara'];

    protected $request;
    protected $dt;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('thirddb');
        $this->dt = $this->db->table('tb_peb');
        $this->request = $request;
    }

    public function Dataexim()
    {
        return $this->db->query("SELECT no_dokumen,tgl_dokumen,sj,tgsj,invoice_new.`m_customer_kode`,m_customer.`nama`,negara, m_item.`idmrp`,kode_konversi, m_produk_kode,m_item.`tipe_customer` AS brg,invoice_item_new.m_satuan_kode,qty,n_weight,'USD',invoice_item_new.total,IFNULL(no_order,'') AS no_order,invoice_new.`kode`,invoice_new.`tgl`
  FROM invoice_dokumen_new 
  LEFT JOIN invoice_item_new ON invoice_item_new.t_si_kode=invoice_dokumen_new.t_si_kode
  LEFT JOIN m_item ON m_item.`kode`=invoice_item_new.`m_item_kode`
  LEFT JOIN invoice_new ON invoice_new.t_si_kode=invoice_dokumen_new.t_si_kode
  LEFT JOIN m_customer ON m_customer.kode=invoice_new.`m_customer_kode`
  LEFT JOIN m_konversi ON m_konversi.`kode_barang`=m_item.`m_produk_kode`
  LEFT JOIN (SELECT t_si_kode,no_dokumen AS sj, tgl_dokumen AS tgsj FROM invoice_dokumen_new WHERE m_dokumen_kode=11) AS msj
       ON msj.t_si_kode=invoice_dokumen_new.`t_si_kode`
       WHERE m_dokumen_kode=10 AND tgl_dokumen>'2024-01-01'")
            ->getResultArray();
    }

    public function Addpeb($data)
    {
        return $this->db->query("INSERT OR IGNORE tb_peb(nopeb) VALUE('$data')");
    }
}