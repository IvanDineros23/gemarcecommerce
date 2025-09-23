<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function fetch(Request $request)
    {
        $user = Auth::user();
        $withUserId = $request->input('with_user_id');

        // If employee, fetch messages with selected user
        if ($user->isEmployee() && $withUserId) {
            $messages = DB::table('chat_messages')
                ->where(function($q) use ($user, $withUserId) {
                    $q->where(function($q2) use ($user, $withUserId) {
                        $q2->where('sender_id', $user->id)->where('receiver_id', $withUserId);
                    })->orWhere(function($q2) use ($user, $withUserId) {
                        $q2->where('sender_id', $withUserId)->where('receiver_id', $user->id);
                    });
                })
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
            return response()->json($messages->reverse()->values());
        }

        // If user, fetch messages with any employee
        if ($user->isUser()) {
            $messages = DB::table('chat_messages')
                ->where(function($q) use ($user) {
                    $q->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
            return response()->json($messages->reverse()->values());
        }

        return response()->json([]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'to_user_id' => 'required|integer|exists:users,id',
        ]);
        $msg = DB::table('chat_messages')->insertGetId([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->to_user_id,
            'message' => $request->message,
            'created_at' => now(),
        ]);
        return response()->json(['success' => true]);
    }

    // For employee: get list of users with active chats
    public function userList()
    {
        $userIds = DB::table('chat_messages')
            ->select('sender_id')
            ->where('receiver_id', Auth::id())
            ->groupBy('sender_id')
            ->pluck('sender_id');
        $users = DB::table('users')->whereIn('id', $userIds)->get(['id','name','email']);
        return response()->json($users);
    }
}
