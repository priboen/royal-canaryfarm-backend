<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Breeder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class AuthenticationController extends Controller
{
    // public function register(RegisterRequest $request)
    // {
    //     $request->validated();

    //     $userData = [
    //         'username' => $request->username,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password)
    //     ];

    //     $user = User::create($userData);
    //     $token = $user->createToken('royalcanary')->plainTextToken;

    //     return response()->json([
    //         'message' => 'User registered successfully',
    //         'user' => $user,
    //         'token' => $token,
    //     ], 200);
    // }


    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('username', $request->username)->with(['breeder'])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('royalcanary')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'nama_breeder' => $user->breeder->name,
            'token' => $token,
        ], 200);
    }

    public function register(Request $request)
    {
        Log::info('Request Data: ', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $photoPath = $request->file('photo')->store('public/photos');
        $photoUrl = url('storage/' . substr($photoPath, 7));

        $breeder = Breeder::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'photo' => $photoUrl,
        ]);

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'breeder' => $breeder,
        ], 201);
    }
}
