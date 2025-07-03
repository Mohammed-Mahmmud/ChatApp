<?php

namespace App\Http\Controllers;

use App\Events\MessageSentEvent;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('chat.index', compact('users'));
    }

    public function send(Request $request)
    {
    $request->validate([
    'user_id' => 'required|exists:users,id',
    'message' => 'required|string',
    ]);

    $message = $request->message;
    $user = User::find($request->user_id);

    // إرسال الحدث عبر البث
    MessageSentEvent::dispatch($message, $user);

    return response()->json(['success' => true, 'message' => 'Message sent successfully']);
    }
}