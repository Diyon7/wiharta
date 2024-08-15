<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'emaa',
            'mhs'
        ];

        foreach ($data as $key => $value) {
            $this->db->table('auth_permissions')->insert(['name' => $value]);
        }
    }
}