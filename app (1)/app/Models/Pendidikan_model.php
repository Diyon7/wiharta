<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Pendidikan_model extends Model
{
    protected $table      = 'pendidikan';
    protected $primaryKey = 'pend_id';

    protected $allowedFields = ['pend_id', 'pend_name'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation     = false;
}
