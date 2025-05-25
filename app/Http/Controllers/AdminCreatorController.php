<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminCreatorController extends Controller
{
    public function createAdmin()
    {
        try {
            // Check if admin already exists
            $adminExists = User::where('role', 'admin')->exists();
            
            if ($adminExists) {
                return view('admin.creator', [
                    'message' => 'Admin user already exists!'
                ]);
            }

            // Create admin user
            User::create([
                'name' => 'Admin',
                'email' => 'admin@garmenique.us',
                'password' => Hash::make('Garmenique2025'),
                'role' => 'admin',
            ]);

            return view('admin.creator', [
                'message' => 'Admin user created successfully!'
            ]);

        } catch (\Exception $e) {
            return view('admin.creator', [
                'message' => 'Failed to create admin user.'
            ]);
        }
    }
} 