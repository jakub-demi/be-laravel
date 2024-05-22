<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'firstname' => 'Min',
                'lastname' => 'Ad',
                'email' => 'admin@a',
                'is_admin' => 1,
                'password' => 'admin'
            ],
            [
                'firstname' => 'Er',
                'lastname' => 'Us',
                'email' => 'user@a',
                'is_admin' => 0,
                'password' => 'admin'
            ]
        ];

        foreach($users as $user) {
            User::create($user);
        }
    }
}
