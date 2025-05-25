<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Order;

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
     * Show the password page.
     */
    public function showPassword()
    {
        return view('account.password');
    }
    
    /**
     * Show the contact information page.
     */
    public function showContact()
    {
        return view('account.contact');
    }
    
    /**
     * Show the orders page.
     */
    public function showOrders()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('account.orders', ['orders' => $orders]);
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
            'country_code' => ['nullable', 'string', 'max:10'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);
        
        // Update user information
        $user->name = $validated['name'];
        $user->country_code = $validated['country_code'];
        $user->phone_number = $validated['phone_number'];
        $user->address = $validated['address'];
        
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
    
    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        // Update password
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('account.password')->with('status', 'Password updated successfully!');
    }
    
    /**
     * Update the user's contact information (phone and address).
     */
    public function updateContact(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $validated = $request->validate([
            'country_code' => ['nullable', 'string', 'max:10'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);
        
        // Update user information
        $user->country_code = $validated['country_code'];
        $user->phone_number = $validated['phone_number'];
        $user->address = $validated['address'];
        $user->save();
        
        return redirect()->route('account.contact')->with('status', 'Contact information updated successfully!');
    }
}