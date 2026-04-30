<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate([
            'email' => 'admin@gmail.com'
        ],[
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::updateOrCreate([
            'email' => 'user@gmail.com'
        ],[
            'name' => 'Regular User',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}
