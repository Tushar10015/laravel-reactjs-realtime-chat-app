<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        $messages->each(function ($message) {
            $message->name = $message->user->name;
        });
        return response()->json($messages, 200);
    }
    public function store(Request $request)
    {
        $message = Message::create([
            'user_id' => 1,  // This should be dynamic
            'message_content' => $request->message_content,
        ]);

        // Broadcast the message to other users
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message], 201);
    }
}
