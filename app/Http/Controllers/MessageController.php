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
        // Get all users who have messages with the current user
        $users = User::whereHas('messages', function($query) {
            $query->where('from_user_id', Auth::id())
                  ->orWhere('to_user_id', Auth::id());
        })
        ->withCount(['messages as unread_count' => function($query) {
            $query->where('is_read', false)
                  ->where('to_user_id', Auth::id());
        }])
        ->with(['messages' => function($query) {
            $query->latest()->first();
        }])
        ->get()
        ->map(function($user) {
            // Get the last message for each user
            $lastMessage = Message::where(function($query) use ($user) {
                $query->where(function($q) use ($user) {
                    $q->where('from_user_id', Auth::id())
                      ->where('to_user_id', $user->id);
                })->orWhere(function($q) use ($user) {
                    $q->where('from_user_id', $user->id)
                      ->where('to_user_id', Auth::id());
                });
            })
            ->latest()
            ->first();

            $user->last_message = $lastMessage ? Str::limit($lastMessage->message, 30) : null;
            return $user;
        });

        return view('messages.message_users', compact('users'));
    }

    /**
     * Get messages for AJAX requests
     */
    public function getMessages($userId)
    {
        $messages = Message::where(function($query) use ($userId) {
            $query->where(function($q) use ($userId) {
                $q->where('from_user_id', Auth::id())
                  ->where('to_user_id', $userId);
            })->orWhere(function($q) use ($userId) {
                $q->where('from_user_id', $userId)
                  ->where('to_user_id', Auth::id());
            });
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        Message::where('to_user_id', Auth::id())
              ->where('from_user_id', $userId)
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
            'to_user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $message = new Message();
        $message->from_user_id = Auth::id();
        $message->to_user_id = $request->to_user_id;
        $message->message = $request->message;
        $message->is_read = false;
        $message->save();

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
} 