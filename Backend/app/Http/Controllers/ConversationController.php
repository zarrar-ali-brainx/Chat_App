<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class ConversationController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        // Validate the request
        $request->validate([
            'type' => 'required|bool',
            'user1_id' => 'integer',
            'user2_id' => 'integer',
            'group_name' => 'string',
            'creator_id' => 'integer',
        ]);

        // Create a new conversation
        $conversation = Conversations::create([
        ]);

        return response()->json(['message' => 'Conversation created successfully', 'conversation' => $conversation]);
    }
    public function getConversation($id)
    {
        $conversation = Conversations::find($id);
        $conversation = Conversations::with(['userOne','userTwo'])->get();

        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        return response()->json($conversation);
    }
     public function index()
     {
         try {
             $conversations = Conversations::with(['userOne','userTwo'])->get();
             return response()->json($conversations, 200);
         } catch (\Exception $e) {
             return response()->json(['error' => 'Internal Server Error'], 500);
         }
     }


}
