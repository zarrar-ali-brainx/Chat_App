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
        $messages = Message::where('conv_id', $conversationId)->with('sender')->get();

        return response()->json($messages);
    }


    public function sendMessage(Request $request, $recipientId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $conversation = Conversations::where(function ($query) use ($recipientId) {
            $query->where('user1_id', Auth::id())
                ->where('user2_id', $recipientId);
        })->orWhere(function ($query) use ($recipientId) {
            $query->where('user1_id', $recipientId)
                ->where('user2_id', Auth::id());
        })->first();

        if (!$conversation) {
            $conversation = Conversations::create([
                'user1_id' => Auth::id(),
                'user2_id' => $recipientId,
//                'creator_id' => Auth::id(),
            ]);
        }
        $user = Auth::user();
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
    public function sendGroupMessage(Request $request, $conversationId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $user = Auth::user();

        $message = new Message([
            'conv_id' => $conversationId,
            'sender_id' => $user['id'],
            'content' => $request->input('content'),
            'time' => now(),
        ]);

        $message->save();
        $conversation = Conversations::with('messages')->where('conv_id',$conversationId);


        return response()->json($conversation);
    }
    public function destroy($id)
    {
        try {
            $message = Message::findOrFail($id);
            $message->delete();

            return response()->json(['message' => 'Message deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting message'], 500);
        }
    }
}
