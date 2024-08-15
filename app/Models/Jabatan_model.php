<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Jabatan_model extends Model
{
    protected $table      = 'pembagian1';
    protected $primaryKey = 'pembagian1_id';

    protected $allowedFields = ['pembagian1_id', 'pembagian1_nama', 'pembagian1_ket'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;
}
