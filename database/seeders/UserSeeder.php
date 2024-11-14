<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // You can change the password here
            'role' => 'admin'
        ]);

        // Create a subadmin user
        User::create([
            'name' => 'Subadmin User',
            'email' => 'subadmin@example.com',
            'password' => Hash::make('password'), // You can change the password here
            'role' => 'subadmin'
        ]);

        // Create a regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'), // You can change the password here
            'role' => 'user'
        ]);
    }
}
