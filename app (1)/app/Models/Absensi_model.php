<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Absensi_model extends Model
{
    protected $table      = 'tbl_izin';
    protected $primaryKey = 'id_tblizin';

    protected $allowedFields = ['pegawai_nip', 'pegawai_nama', 'grup', 'tanggal', 'file_image', 'in', 'out', 'user_id', 'unit', 'sub_unit', 'izin', 'ket', 'verified'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;
}