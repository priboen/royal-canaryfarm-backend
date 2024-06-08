<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $userData = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = User::create($userData);
        $token = $user->createToken('royalcanary')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 200);
    }


    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('royalcanary')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ], 200);
    }
}
