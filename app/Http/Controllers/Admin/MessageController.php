<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display all messages grouped by user
     */
    public function index()
    {
        // Get all users who have messages with admin
        $users = User::whereHas('messages', function($query) {
                $query->where('is_admin', true)
                      ->orWhere('to_user_id', function($q) {
                          $q->select('id')
                            ->from('users')
                            ->where('role', 'admin')
                            ->limit(1);
                      });
            })
            ->where('role', '!=', 'admin')
            ->withCount(['messagesReceived as unread_count' => function($query) {
                $query->where('is_read', false)
                      ->where('is_admin', true);
            }])
            ->get()
            ->map(function($user) {
                // Get the last message for each user
                $lastMessage = Message::where(function($query) use ($user) {
                    $query->where(function($q) use ($user) {
                        $q->where('from_user_id', $user->id);
                    })->orWhere(function($q) use ($user) {
                        $q->where('to_user_id', $user->id);
                    });
                })
                ->latest()
                ->first();

                $user->last_message = $lastMessage ? Str::limit($lastMessage->message, 30) : null;
                $user->last_message_time = $lastMessage ? $lastMessage->created_at : null;
                return $user;
            })
            ->sortByDesc('last_message_time')  // Sort by most recent message first
            ->values();  // Re-index array after sorting

        // Calculate total unread messages
        $totalUnread = $users->sum('unread_count');

        return view('admin.message_admin', [
            'users' => $users,
            'totalUnread' => $totalUnread
        ]);
    }

    /**
     * Get messages data for AJAX requests
     */
    public function getMessages($userId)
    {
        // Get real messages between user and admin
        $messages = Message::where(function($query) use ($userId) {
                $query->where('from_user_id', $userId)
                      ->orWhere('to_user_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($message) use ($userId) {
                return [
                    'id' => $message->id,
                    'content' => $message->message,
                    'is_admin' => $message->is_admin,
                    'created_at' => $message->created_at->setTimezone('Asia/Jakarta')->format('M d, Y H:i').' WIB'
                ];
            });

        // Mark messages as read
        Message::where('to_user_id', Auth::id())
              ->where('from_user_id', $userId)
              ->where('is_read', false)
              ->update(['is_read' => true]);

        return response()->json($messages);
    }

    /**
     * Reply to a user's message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'user_id' => 'required'
        ]);

        // Get admin user
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            return response()->json(['error' => 'Admin user not found'], 500);
        }

        // Create new message
        $message = new Message();
        $message->from_user_id = $admin->id;
        $message->to_user_id = $request->user_id;
        $message->message = $request->message;
        $message->is_read = false;
        $message->is_admin = true;
        $message->save();

        return response()->json([
            'id' => $message->id,
            'content' => $message->message,
            'created_at' => $message->created_at->setTimezone('Asia/Jakarta')->format('M d, Y H:i').' WIB'
        ]);
    }
} 