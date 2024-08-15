<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $groups = new GroupModel();
        $groups->insert([
            'name' => 'sdm',
            'description' => 'sdm'
        ]);
        $groups->insert([
            'name' => 'vendor',
            'description' => 'vendor'
        ]);

        $permissions = new PermissionModel();
        $superadmin = $permissions->findAll();
        foreach ($superadmin as $permission) {
            $groups->addPermissionToGroup($permission->id, $groups->getInsertID());
        }

        $vendor = $permissions->where('name', 'emaa')->findAll();
        foreach ($vendor as $permission) {
            $groups->addPermissionToGroup($permission->id, $groups->getInsertID());
        }
    }
}