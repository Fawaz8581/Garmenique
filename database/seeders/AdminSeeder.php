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
            'email' => 'admin@garmenique.us',
            'password' => Hash::make('Garmenique2025'), // Ganti 'password' dengan password yang Anda inginkan
            'role' => 'admin',
        ]);
    }
}