<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\BreederRequest;
use App\Models\Breeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        try {
            $user = Auth::user();
            $breeder = $user->breeder;

            // Ensure photo path is correct
            if ($breeder->photo) {
                // Assuming photo is stored in storage/photos
                $photoPath = $breeder->photo;
            } else {
                $photoPath = null; // Set a default if there is no photo
            }

            return response()->json([
                'username' => $user->username,
                'name' => $breeder->name,
                'address' => $breeder->address,
                'phone' => $breeder->phone,
                'photo' => $photoPath, // Full URL
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getProfileById($id)
    {
        try {
            $breeder = Breeder::findOrFail($id);

            // Ensure photo path is correct
            if ($breeder->photo) {
                // Assuming photo is stored in storage/photos
                $photoPath = $breeder->photo;
            } else {
                $photoPath = null; // Set a default if there is no photo
            }

            return response()->json([
                'name' => $breeder->name,
                'address' => $breeder->address,
                'phone' => $breeder->phone,
                'photo' => $photoPath, // Full URL
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Breeder not found',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
