<?php

namespace App\Http\Controllers;

use App\Models\Chicks;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ChicksController extends Controller
{
    public function addChicks(Request $request)
    {
        try {
            $request->validate([
                'ring_number' => 'required',
                'photo' => 'required',
                'date_of_birth' => 'required',
                'gender' => 'nullable',
                'canary_type' => 'nullable',
                'parent_id' => 'required|exist:bird_parents,id',
                'status_id' => 'required|exist:statuses_id',
            ]);

            $chicks = Chicks::create([
                'ring_number' => $request->ring_number,
                'photo' => $request->photo,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'canary_type' => $request->canary_type,
            ]);

            Relation::create([
                'chicks_id' => $chicks->id,
                'bird_parent_id' => $request->parent_id,
                'status_id' => $request->status_id,
            ]);
            return response()->json(['chick' => $chicks], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Breeder not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong, please try again later.'], 500);
        }
    }
}
