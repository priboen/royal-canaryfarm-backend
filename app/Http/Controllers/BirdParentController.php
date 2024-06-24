<?php

namespace App\Http\Controllers;

use App\Http\Requests\BirdParentsRequest;
use App\Models\BirdParent;
use App\Models\Breeder;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BirdParentController extends Controller
{
    public function addBirds(Request $request)
    {
        try {
            $userId = Auth::id();
            Log::info('User ID: ' . $userId);
            $breeder = Breeder::where('user_id', $userId)->firstOrFail();
            Log::info('Breeder ID: ' . $breeder->id);

            $request->validate([
                'ring_number' => 'required',
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'date_of_birth' => 'required',
                'gender' => 'required',
                'canary_type' => 'required',
                'type_description' => 'required',
                'price' => 'required|numeric|min:0',
            ]);

            $photoPath = $request->file('photo')->store('public/canary');
            $photoUrl = url('storage/' . substr($photoPath, 7));

            $bird = BirdParent::create([
                'breeder_id' => $breeder->id,
                'ring_number' => $request->ring_number,
                'photo' => $photoUrl,
                'price' => $request->price,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'canary_type' => $request->canary_type,
                'type_description' => $request->type_description,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data Induk berhasil ditambahkan!',
                'data' => $bird
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Tidak ada data peternak!',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan data induk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBirdsById(Request $request, $gender = null)
    {
        try {
            $userId = Auth::id();
            Log::info('User ID: ' . $userId);

            $breeder = Breeder::where('user_id', $userId)->firstOrFail();
            Log::info('Breeder ID: ' . $breeder->id);

            $query = BirdParent::where('breeder_id', $breeder->id);

            if ($gender) {
                Log::info('Gender filter applied: ' . $gender);
                $query->where('gender', $gender);
            } else {
                Log::info('No gender filter applied.');
            }

            $birds = $query->get();
            Log::info('Birds retrieved: ' . $birds->count());

            return response()->json([
                'status' => 200,
                'data' => $birds
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tidak ada data peternak!'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function fetchBirds()
    {
        try {
            $userId = Auth::id();
            Log::info('User ID: ' . $userId);

            $breeder = Breeder::where('user_id', $userId)->firstOrFail();
            Log::info('Breeder ID: ' . $breeder->id);

            $canary = BirdParent::where('breeder_id', $breeder->id)->get()->map(function ($item) {
                if ($item->photo) {
                    $item->photo = url('storage/' . substr($item->photo, 7));
                }
                return $item;
            });

            if ($canary->count() > 0) {
                Log::info('Birds count: ' . $canary->count());
                return response()->json([
                    'status' => 200,
                    'data' => $canary
                ], 200);
            } else {
                Log::info('No birds found for breeder ID: ' . $breeder->id);
                return response()->json([
                    'status' => 404,
                    'message' => "Tidak ada data Induk Burung."
                ], 404);
            }
        } catch (ModelNotFoundException $e) {
            Log::error('Breeder not found for user ID: ' . $userId);
            return response()->json([
                'status' => 404,
                'message' => 'Tidak ada data peternak!'
            ], 404);
        } catch (Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => "Gagal mengambil data kuliner.",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
