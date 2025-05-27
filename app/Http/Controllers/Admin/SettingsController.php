<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // Get all admin users
        $adminUsers = User::where('role', 'admin')->get();
        
        return view('admin.settings', compact('adminUsers'));
    }
    
    /**
     * Create a new admin user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAdminUser(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            // Create the new admin user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
            ]);
            
            return redirect()->back()->with('success', 'Admin user created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create admin user: ' . $e->getMessage());
        }
    }
} 