<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::make([
            'firstname' => 'Min',
            'lastname' => 'Ad',
            'email' => 'admin@admin.a',
            'is_admin' => 1,
        ]);

        $user->password = Hash::make('admin');
        $user->save();
    }
}
