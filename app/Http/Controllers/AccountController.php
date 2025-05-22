<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Show the account settings page.
     */
    public function showSettings()
    {
        return view('account.settings');
    }
    
    /**
     * Show the orders page.
     */
    public function showOrders()
    {
        return view('account.orders');
    }
    
    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        
        // Update name
        $user->name = $validated['name'];
        
        // Handle password change if requested
        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('The current password is incorrect.');
                    }
                }],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('account.settings')->with('status', 'Profile updated successfully!');
    }
}