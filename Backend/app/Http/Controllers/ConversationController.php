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
//        $conversation = Conversations::find($id);
        $conversation = Conversations::where('id',$id)->with(['userOne','userTwo'])->first();

        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        return response()->json($conversation);
    }
     public function index()
     {
         try {
             $conversations = Conversations::whereHas('userOne',function ($q){
                 $q->where('user1_id',auth()->user()->id);
             })->orWhereHas('userTwo',function ($q){
                 $q->where('user2_id',auth()->user()->id);
             })->with(['userOne','userTwo'])->get();
             return response()->json($conversations, 200);
         } catch (\Exception $e) {
             return response()->json(['error' => 'Internal Server Error'], 500);
         }
     }

    public function checkConversation(Request $request)
    {
        $user1Id = $request->input('user1_id');
        $user2Id = $request->input('user2_id');

        // Check if a conversation exists between user1 and user2
        $conversation = Conversations::where(function ($query) use ($user1Id, $user2Id) {
            $query->where('user1_id', $user1Id)
                ->where('user2_id', $user2Id);
        })->orWhere(function ($query) use ($user1Id, $user2Id) {
            $query->where('user1_id', $user2Id)
                ->where('user2_id', $user1Id);
        })->first();

        return response()->json($conversation);
    }
}
