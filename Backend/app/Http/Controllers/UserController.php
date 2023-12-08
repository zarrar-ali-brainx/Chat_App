<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id','<>',auth()->user()->id)->get()->map(function($item){
            $item->conversation = $item->firstConversations()->where('user2_id',auth()->user()->id)->first() ?? $item->secondConversations()->where('user1_id',auth()->user()->id)->first() ?? null;
            return $item;
        });

        return response()->json($users);
    }
}
