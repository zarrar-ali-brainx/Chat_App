<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();

        User::create([
            'name' => $input['name'],
            'phone_no' => $input['phone_no'],
            'password' => Hash::make($input['password'])

        ]);
        return response()->json(['status' => true,
            'message' => "registration success"
        ]);
    }
}
