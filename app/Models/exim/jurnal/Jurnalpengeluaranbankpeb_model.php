<?php

namespace App\Models\exim\jurnal;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Jurnalpengeluaranbankpeb_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'beacukai_jurnal_pengeluaranbank_peb';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'kode', 'beacukai_jurnal_pembelian_id', 'nilai_peb', 'id_jurnal_pengeluaranbank'];

    protected $request;
    protected $dt;
    protected $rh;
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('beacukai_jurnal_pengeluaranbank_peb');
        // $this->rh = $this->db->table('beacukai_jurnal_penerimaanbank');
        $this->request = $request;
    }

    public function Bank()
    {
        return $this->db->query("SELECT * FROM ms_bank")
            ->getResultArray();
    }

    public function Edit($data)
    {
        return $this->select("nilai_peb")
            ->where("kode", $data)
            ->get()->getResultArray();
    }
}
