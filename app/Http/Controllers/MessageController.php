<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    /**
     * Display user's messages
     */
    public function userMessages()
    {
        return view('messages.message_users');
    }

    /**
     * Get messages for AJAX requests
     */
    public function getMessages()
    {
        // Get admin user
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            return response()->json([]);
        }

        // Get messages between current user and admin
        $messages = Message::where(function($query) use ($admin) {
                $query->where(function($q) use ($admin) {
                    $q->where('from_user_id', Auth::id())
                      ->where('to_user_id', $admin->id);
                })->orWhere(function($q) use ($admin) {
                    $q->where('from_user_id', $admin->id)
                      ->where('to_user_id', Auth::id());
                });
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($message) {
                return [
                    'id' => $message->id,
                    'content' => $message->message,
                    'is_admin' => $message->is_admin,
                    'created_at' => $message->created_at->setTimezone('Asia/Jakarta')->format('M d, Y H:i').' WIB'
                ];
            });

        // Mark messages as read
        Message::where('to_user_id', Auth::id())
              ->where('is_read', false)
              ->update(['is_read' => true]);

        return response()->json($messages);
    }

    /**
     * Send a new message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Get admin user
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            return response()->json(['error' => 'Admin user not found'], 500);
        }

        $message = new Message();
        $message->from_user_id = Auth::id();
        $message->to_user_id = $admin->id;
        $message->message = $request->message;
        $message->is_read = false;
        $message->is_admin = false;
        $message->save();

        return response()->json([
            'id' => $message->id,
            'content' => $message->message,
            'created_at' => $message->created_at->setTimezone('Asia/Jakarta')->format('M d, Y H:i').' WIB'
        ]);
    }
} 