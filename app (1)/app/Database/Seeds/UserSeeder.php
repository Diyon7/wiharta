<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Password;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = new UserModel();
        $groups = new GroupModel();

        $users->insert([
            'username' => 'yusufsdm',
            'email' => 'yusufsdm@wkag.id',
            'password_hash' => Password::hash('yusufpersonaliawka2023'),
            'active' => 1
        ]);

        $groups->addUserToGroup($users->getInsertID(), 1);

        $users->insert([
            'username' => 'dinarsdm',
            'email' => 'dinarsdm@wkag.id',
            'password_hash' => Password::hash('dinarsdmpersonaliawka2023'),
            'active' => 1
        ]);

        // $users->insert([
        //     'username' => 'sakti',
        //     'email' => 'sakti@wkag.id',
        //     'password_hash' => Password::hash('saktiwkagresik2023'),
        //     'active' => 1
        // ]);

        // $users->insert([
        //     'username' => 'ska',
        //     'email' => 'ska@wkag.id',
        //     'password_hash' => Password::hash('skawkagresik2023'),
        //     'active' => 1
        // ]);

        // $users->insert([
        //     'username' => 'hmn',
        //     'email' => 'hmn@wkag.id',
        //     'password_hash' => Password::hash('hmnwkagresik2023'),
        //     'active' => 1
        // ]);

        // $users->insert([
        //     'username' => 'peg',
        //     'email' => 'peg@wkag.id',
        //     'password_hash' => Password::hash('pegwkagresik2023'),
        //     'active' => 1
        // ]);

        // $users->insert([
        //     'username' => 'ajg',
        //     'email' => 'ajg@wkag.id',
        //     'password_hash' => Password::hash('ajgwkagresik2023'),
        //     'active' => 1
        // ]);
    }
}