<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Show the contact page.
     */
    public function showContactForm()
    {
        return view('contact');
    }

    /**
     * Handle the contact form submission.
     */
    public function submitContactForm(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'message' => 'required|string',
        ]);

        // Get admin user
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            return response()->json(['error' => 'Admin user not found'], 500);
        }

        // Get the authenticated user ID if logged in, otherwise create a message from a guest
        $fromUserId = Auth::check() ? Auth::id() : null;

        // Create message content with user info if not authenticated
        $messageContent = $validated['message'];
        
        if (!$fromUserId) {
            $messageContent = "Contact Form Submission:\n\n" .
                "Name: " . $validated['firstName'] . ' ' . $validated['lastName'] . "\n" .
                "Email: " . $validated['email'] . "\n\n" .
                "Message:\n" . $validated['message'];
        }

        // Create message
        $message = new Message();
        
        if ($fromUserId) {
            // If user is logged in, use their ID
            $message->from_user_id = $fromUserId;
        } else {
            // If guest, use admin ID but mark message as not from admin
            $message->from_user_id = $admin->id;
        }
        
        $message->to_user_id = $admin->id;
        $message->message = $messageContent;
        $message->is_read = false;
        $message->is_admin = false;
        $message->save();

        // If this is an AJAX request, return JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.',
                'redirect' => Auth::check() ? route('user.messages') : null
            ]);
        }
        
        // If it's a regular form submission, redirect
        if (Auth::check()) {
            return redirect()->route('user.messages')->with('status', 'Message sent successfully! Check your messages for a response.');
        }
        
        return redirect()->back()->with('status', 'Thank you for your message! We will get back to you soon.');
    }
}
