<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('felixlim2005'), // Ganti 'password' dengan password yang Anda inginkan
            'role' => 'admin',
        ]);
    }
}