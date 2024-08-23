<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $users = User::all();

        if ($user->isAdmin()) {
            return view('admin.chat', compact('users'));
        } elseif ($user->isEmployee()) {
            return view('employee.chat', compact('users'));
        }

        abort(403, 'Unauthorized action.');
    }
    public function showChat($userId)
    {
        $chatUser = User::findOrFail($userId);
        $messages = Message::where(function ($query) use ($userId) {
                $query->where('sender_id', Auth::id())
                      ->orWhere('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->orWhere('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat', compact('chatUser', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->save();

        return response()->json(['status' => 'Message sent successfully!']);
    }

    public function fetchMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}
