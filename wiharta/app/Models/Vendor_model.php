<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Vendor_model extends Model
{
    protected $table      = 'pembagian3';
    protected $primaryKey = 'pembagian3_id';

    protected $allowedFields = ['pembagian3_id', 'pembagian3_nama', 'pembagian3_ket'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;
}
