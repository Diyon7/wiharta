<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Pegawaitemp_Model extends Model
{
    protected $table      = 'pegawai_temp';
    protected $primaryKey = 'pegawai_id';

    protected $allowedFields = ['pegawai_pin', 'pegawai_nip', 'pegawai_nama', 'pegawai_alias', 'pegawai_telp', 'tempat_lahir', 'tgl_lahir', 'pembagian1_id', 'pembagian2_id', 'pembagian3_id', 'pembagian4_id', 'pembagian5_id', 'pembagian6_id', 'tgl_mulai_kerja', 'tgl_resign', 'gender', 'tgl_masuk_pertama', 'golongan', 'grup', 'grup_t', 'grup_jam_kerja', 'resign', 'pegawai_id', 'user', 'created_at', 'updated_at'];

    protected $request;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->dt = $this->db->table('tmp');
        $this->request = $request;
    }

}