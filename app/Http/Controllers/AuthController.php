<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $dataValidated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);


        $user = User::where('email', $dataValidated['email'])->first();

        if (!$user || !Hash::check($dataValidated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
            'user' => $user,
        ], 200);
    }
    public function signin(Request $request)
    {

        $dataValidated = $request->validate(([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]));

        $user = User::create([
            'name' => $dataValidated['name'],
            'last_name' => $dataValidated['last_name'],
            'email' => $dataValidated['email'],
            'password' => bcrypt($dataValidated['password']),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }
    public function logout(Request $request)
    {

        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'User logged out successfully',
        ], 200);
    }
}
