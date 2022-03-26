<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'user_email' => 'required|string',
            'user_name' => 'required|string',
            'image' => 'required|string',
            'google_id' => 'required|string'
        ]);

        $have_user = User::where('user_email', $request->user_email)->first();

        if (!$have_user) {
            $user = User::create($request->all());

            $token = $user->createToken('metamatedrive')->plainTextToken;

            $user->remember_token = $token;

            $user->save();

            $response = [
                'user' => $user,
                'token' => $token
            ];


            return response()->json($response, 201);
        } else {
            $response = [
                'user' => $have_user,
                'token' => $have_user->remember_token
            ];
            return response()->json($response, 200);
        }
    }
}
