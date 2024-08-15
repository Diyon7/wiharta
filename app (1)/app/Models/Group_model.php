<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Group_model extends Model
{
    protected $table      = 'group_user';
    protected $primaryKey = 'id_group';

    protected $allowedFields = ['group', 'group_k', 'group_jk'];

    protected $useTimestamps = false;

    protected $skipValidation     = false;
}