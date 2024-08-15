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

        // $users->insert([
        //     'username' => 'jarotsdm',
        //     'email' => 'jarot@sdm.wiharta.com',
        //     'password_hash' => Password::hash('jarotpersonaliawka2023'),
        //     'active' => 1
        // ]);

        // $users->insert([
        //     'username' => 'haa',
        //     'email' => 'haa@wiharta.com',
        //     'password_hash' => Password::hash('haawkagresik2023'),
        //     'active' => 1
        // ]);

        // $users->insert([
        //     'username' => 'sakti',
        //     'email' => 'sakti@wkag.id',
        //     'password_hash' => Password::hash('saktiwkagresik2023'),
        //     'active' => 1
        // ]);

        // $users->insert([
        //     'username' => 'yuli',
        //     'email' => 'benaryuli@wgmail.com',
        //     'password_hash' => Password::hash('110702'),
        //     'active' => 1
        // ]);

        $users->insert([
            'username' => 'yosephbc',
            'email' => 'yoseph@wiharta.com',
            'password_hash' => Password::hash('yosephbc2023'),
            'active' => 1
        ]);

        $users->insert([
            'username' => 'tia',
            'email' => 'tia@wiharta.com',
            'password_hash' => Password::hash('tiabc'),
            'active' => 1
        ]);

        // $users->insert([
        //     'username' => 'hmn',
        //     'email' => 'hmn@wkag.id',
        //     'password_hash' => Password::hash('hmngresik2023'),
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

        $groups->addUserToGroup($users->getInsertID(), 1);
    }
}
