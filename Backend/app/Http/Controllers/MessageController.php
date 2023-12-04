<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversations;

class MessageController extends Controller
{
    public function fetchMessages($conversationId)
    {
        $messages = Message::where('conv_id', $conversationId)->get();

        return response()->json($messages);
    }


    public function sendMessage(Request $request, $recipientId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        // Check if a conversation already exists between the logged-in user and the recipient
        $conversation = Conversations::where(function ($query) use ($recipientId) {
            $query->where('user1_id', Auth::id())
                ->where('user2_id', $recipientId);
        })->orWhere(function ($query) use ($recipientId) {
            $query->where('user1_id', $recipientId)
                ->where('user2_id', Auth::id());
        })->first();

        // If the conversation doesn't exist, create a new one
        if (!$conversation) {
            $conversation = Conversations::create([
                'user1_id' => Auth::id(),
                'user2_id' => $recipientId,
//                'creator_id' => Auth::id(),
            ]);
        }
        $user = Auth::user();
        // Now, use the conversation ID to create the message
        $message = new Message([
            'conv_id' => $conversation->id,
            'sender_id' => $user['id'],
            'content' => $request->input('content'),
            'time' => now(),
        ]);

        $message->save();
    return response()->json($conversation);
//        return response()->json(['message' => 'Message sent successfully']);
    }


}
