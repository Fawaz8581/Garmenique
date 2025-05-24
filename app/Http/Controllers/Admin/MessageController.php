<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display all messages grouped by user
     */
    public function index()
    {
        // Return dummy data for users
        $dummyUsers = [
            (object)[
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'unread_count' => 2
            ],
            (object)[
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'unread_count' => 0
            ]
        ];

        return view('admin.message_admin', ['users' => collect($dummyUsers)]);
    }

    /**
     * Get messages data for AJAX requests
     */
    public function getMessages($userId)
    {
        // Return dummy messages
        $dummyMessages = [
            [
                'id' => 1,
                'content' => 'Hello, I have a question about my order',
                'is_admin' => false,
                'created_at' => now()->subHours(2)->format('M d, Y H:i')
            ],
            [
                'id' => 2,
                'content' => 'Sure, how can I help you?',
                'is_admin' => true,
                'created_at' => now()->subHours(1)->format('M d, Y H:i')
            ]
        ];

        return response()->json($dummyMessages);
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

        // Return dummy response for sent message
        return response()->json([
            'id' => rand(100, 999),
            'content' => $request->message,
            'created_at' => now()->format('M d, Y H:i')
        ]);
    }
} 