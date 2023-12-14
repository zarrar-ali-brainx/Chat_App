<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
use App\Models\GroupMember;
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
            'type' => 'required|boolean',
            'group_name' => 'string|required_if:type,0',
            'creator_id' => 'integer|nullable',

        ]);

        $conversation = Conversations::create([
            'type' => $request->type,
            'group_name' => $request->group_name,
            'creator_id' => $request->creator_id,
        ]);

        if ($request->type == 0 && $request->group_name) {
            $this->addGroupMembers($conversation, $request->creator_id, $request->groupMembers);
        }

        return response()->json($conversation);
    }

    private function addGroupMembers($conversation, $creator_id, $groupMembers)
    {
        foreach ($groupMembers as $userId) {
            $isAdmin = ($userId == $creator_id) ? 1 : 0;

            GroupMember::create([
                'group_id' => $conversation->id,
                'user_id' => $userId,
                'isAdmin' => $isAdmin,
            ]);
        }
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
            $conversations = Conversations::where(function ($query) {
                $query->whereHas('userOne', function ($q) {
                    $q->where('user1_id', auth()->user()->id);
                })->orWhereHas('userTwo', function ($q) {
                    $q->where('user2_id', auth()->user()->id);
                });

                $query->orWhere(function ($query) {
                    $query->whereNull('user1_id')
                        ->whereNull('user2_id')
                        ->whereHas('users', function ($q) {
                            $q->where('user_id', auth()->user()->id);
                        });
                });
            })
                ->with(['userOne', 'userTwo','users'])
                ->get();


            return response()->json($conversations, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
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
    public function createGroup(Request $request)
    {
        $user = Auth::user();
        // Validate the request
        $request->validate([
            'type' => 'required|bool',
            'group_name' => 'required|string',
            'creator_id' => 'required|integer',
        ]);

        // Create a new conversation
        $conversation = Conversations::create([
            'type' => $request->input('type'),
            'group_name' => $request->input('group_name'),
        ]);

        // Attach the creator user to the conversation
        $conversation->users()->attach($request->input('creator_id'));

        return response()->json(['message' => 'Conversation created successfully', 'conversation' => $conversation]);
    }
}
