<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Unit_model extends Model
{
    protected $table      = 'pembagian4';
    protected $primaryKey = 'pembagian4_id';

    protected $allowedFields = ['pembagian4_id', 'pembagian4_nama', 'pembagian4_ket'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;
}