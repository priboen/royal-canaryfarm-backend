<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\BreederRequest;
use App\Models\Breeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        try {
            $user = Auth::user();
            $breeder = $user->breeder;

            return response()->json([
                'id' => $user->id,  // Ensure this matches the expected profile structure
                'username' => $user->username,
                'name' => $breeder->name,
                'address' => $breeder->address,
                'phone' => $breeder->phone,
                'photo' => $breeder->photo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
