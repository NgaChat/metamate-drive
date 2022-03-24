<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fileds = $request->validate([
            'user_email' => 'required|string',
            'user_name' => 'required|string',
            'image' => 'required|string',
            'google_id' => 'required|string'
        ]);

        $have_user = User::where('user_email', $fileds['user_email'])->first();

        if (!$have_user) {
            $user = User::create([
                'user_name' => $fileds['user_name'],
                'user_email' => $fileds['user_email'],
                'image' => $fileds['image'],
                'google_id' => $fileds['google_id'],

            ]);
            $token = $user->createToken('metamatedrive')->plainTextToken;

            $user->remember_token = $token;

            $user->save();

            $response = [
                'user' => $user,
                'token' => $token
            ];


            return response()->json($response, 201);
        } else {

            return response()->json($have_user->remember_token, 200);
        }
    }
}
