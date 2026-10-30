<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginAuthController extends Controller
{
   
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::with('roles')
            ->where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        
return response()->json([
    'status' => true,
    'message' => 'Login successful',
    'data' => [
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->roles->role ?? null,
        ],
        'token' => $token,
        'token_type' => 'Bearer',
    ],
], 200);

    }



    public function me(Request $request)
    {
        return response()->json([
            'status' => true,
            'data' => $request->user()->load('roles'),
        ], 200);
    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout successful',
        ], 200);
    }
}




