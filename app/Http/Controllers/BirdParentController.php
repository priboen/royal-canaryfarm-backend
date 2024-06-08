<?php

namespace App\Http\Controllers;

use App\Models\BirdParent;
use App\Models\Breeder;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BirdParentController extends Controller
{

    public function getBirds()
    {
        try {
            $userId = Auth::id();
            $breeder = Breeder::where('user_id', $userId)->firstOrFail();
            $bird = BirdParent::where('breeder_id', $breeder->id)->get();

            return response()->json([
                'status' => 200,
                'data' => $bird
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tidak ada data peternak!'], 404);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function addBirds(Request $request)
    {
        try {
            $request->validate([
                'ring_number' => 'required',
                'photo' => 'required',
                'date_of_birth' => 'required',
                'gender' => 'required',
                'canary_type' => 'required',
                'type_description' => 'required',
            ]);

            $userId = Auth::id();
            $breeder = Breeder::where('user_id', $userId)->firstOrFail();

            $bird = BirdParent::create([
                'breeder_id' => $breeder->id,
                'ring_number' => $request->ring_number,
                'photo' => $request->photo,
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
                'Error!' => $e->errors()
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
}
