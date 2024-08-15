<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Jnsizin_model extends Model
{
    protected $table      = 'jns_izin';
    protected $primaryKey = 'izin_jenis_id';

    protected $allowedFields = ['izin_jenis_id', 'izin_jenis_name'];

    protected $skipValidation     = false;
}