<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Divisi_model extends Model
{
    protected $table      = 'pembagian2';
    protected $primaryKey = 'pembagian2_id';

    protected $allowedFields = ['pembagian2_id', 'pembagian2_nama', 'pembagian2_ket'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;
}
