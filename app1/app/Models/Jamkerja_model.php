<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Jamkerja_model extends Model
{
    protected $table      = 'jam_kerja';
    protected $primaryKey = 'jk_id';

    protected $allowedFields = ['jk_id', 'jk_name', 'jk_kode', 'jk_bcin', 'jk_ecout', 'jk_countas'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;


    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function JampegawaiIn($data)
    {
        return $this->db->query("SELECT att_log.`scan_date` AS scanin FROM pegawai
        JOIN att_log ON pegawai.`pegawai_pin`=att_log.`pin`
        WHERE pegawai.`pegawai_pin`='" . $data['idkar'] . "' AND att_log.`scan_date` BETWEEN '" . $data['inmin'] . "' AND '" . $data['inmax'] . "'")->getRowArray();
    }
    public function JampegawaiOut($data)
    {
        return $this->db->query("SELECT att_log.`scan_date` AS scanout FROM pegawai
        JOIN att_log ON pegawai.`pegawai_pin`=att_log.`pin`
        WHERE pegawai.`pegawai_pin`='" . $data['idkar'] . "' AND att_log.`scan_date` BETWEEN '" . $data['outmin'] . "' AND '" . $data['outmax'] . "'")->getRowArray();
    }
}