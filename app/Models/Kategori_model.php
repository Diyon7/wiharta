<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Kategori_model extends Model
{
    protected $table      = 'pembagian6';
    protected $primaryKey = 'pembagian6_id';

    protected $allowedFields = ['pembagian6_id', 'pembagian6_nama', 'pembagian6_ket'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;
}
