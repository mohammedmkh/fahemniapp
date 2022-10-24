<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'verify'         => '',
                'phone'          => '',
                'sex'            => '',
                'age'            => '',
                'lat'            => '',
                'long'           => '',
            ],
        ];

        User::insert($users);
    }
}
