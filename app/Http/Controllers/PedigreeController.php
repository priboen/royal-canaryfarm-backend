<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChickRequest;
use App\Models\BirdParent;
use App\Models\Chicks;
use App\Models\Pedigree;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PedigreeController extends Controller
{
    public function addPedigree(Request $request, ChickRequest $chickRequest)
    {
        try {
            $chickRequest->validated();

            // Validate request
            $validator = Validator::make($request->all(), [
                'dadparent_id' => 'required|exists:bird_parents,id',
                'momparent_id' => 'required|exists:bird_parents,id',
                'photo' => 'required|image' // Ensure photo is required and is an image
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Error',
                    'error' => $validator->errors()
                ], 400);
            }

            // Check if file is uploaded
            if (!$request->hasFile('photo')) {
                return response()->json([
                    'message' => 'Photo file is missing'
                ], 400);
            }

            // Store photo
            $photoPath = $request->file('photo')->store('public/chicks');
            $photoUrl = url('storage/' . substr($photoPath, 7));

            // Create Chicks entry
            $chicks = Chicks::create([
                'ring_number' => $chickRequest->ring_number,
                'photo' => $photoUrl,
                'date_of_birth' => $chickRequest->date_of_birth,
                'gender' => $chickRequest->gender,
                'canary_type' => $chickRequest->canary_type,
            ]);

            // Create Pedigree entries
            $pedigreeMale = Pedigree::create([
                'chicks_id' => $chicks->id, // Ensure chicks_id is passed
                'parent_id' => $request->dadparent_id,
                'relations_id' => 1,
            ]);

            $pedigreeFemale = Pedigree::create([
                'chicks_id' => $chicks->id, // Ensure chicks_id is passed
                'parent_id' => $request->momparent_id,
                'relations_id' => 2,
            ]);

            return response()->json([
                'message' => 'Data berhasil di simpan!',
                'chicks' => $chicks,
                'dad' => $pedigreeMale,
                'mom' => $pedigreeFemale,
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
                'message' => 'Gagal menambahkan data anak burung!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
