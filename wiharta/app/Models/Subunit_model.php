<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Subunit_model extends Model
{
    protected $table      = 'pembagian5';
    protected $primaryKey = 'pembagian5_id';

    protected $allowedFields = ['pembagian5_id', 'pembagian5_nama', 'pembagian5_ket'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;
}
