<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class LoginController extends Controller
{
    public function check(Request $request)
    {
        $credentials = $request->validate([
            'phone_no' => ['required', 'numeric'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'access_token' => $token,
            ]);
        }


        return response()->json(['status' => false]);
    }

}
