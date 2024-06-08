<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\BirdParentsRequest;
use App\Http\Requests\ChickRequest;
use App\Models\BirdParent;
use App\Models\Chicks;
use App\Models\Pedigree;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function addChickFeed(ChickRequest $chickReq, Request $request)
    {
        try {
            $chickReq->validated();

            $chickData = [
                'ring_number' => $chickReq->ring_number,
                'photo' => $chickReq->photo,
                'date_of_birth' => $chickReq->date_of_birth,
                'gender' => $chickReq->gender,
                'canary_type' => $chickReq->canary_type,
            ];
            $chicks = Chicks::create($chickData);

            $fatherData = [
                'chicks_id' => $chicks->id,
                'bird_parent_id' => $request->bird_parent_id,
                'status_id' => $request->status_id,
            ];

            $motherData = [
                'chicks_id' => $chicks->id,
                'bird_parent_id' => $request->bird_parent_id,
                'status_id' => $request->status_id,
            ];

            $father = Pedigree::create($fatherData);
            $mother = Pedigree::create($motherData);

            return response()->json([
                'message' => 'Feed added successfully',
                'data' => $chicks, $father, $mother
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getChickFeed()
    {
        try {
            $feed = Chicks::with('pedigree')->get();
            return response()->json(['feed' => $feed], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getChickFeedById($id)
    {
        try {
            $feed = Chicks::with('pedigree')->find($id);
            return response()->json(['feed' => $feed], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addBirdParent(BirdParentsRequest $indukReq)
    {
        try {
            $indukReq->validated();
            $birdParentData = [
                'breeder_id' => $indukReq->breeder_id,
                'ring_number' => $indukReq->ring_number,
                'photo' => $indukReq->photo,
                'date_of_birth' => $indukReq->date_of_birth,
                'gender' => $indukReq->gender,
                'canary_type' => $indukReq->canary_type,
                'type_description' => $indukReq->type_description
            ];

            $birdParent = BirdParent::create($birdParentData);

            return response()->json([
                'message' => 'Data induk berhasil ditambahkan.',
                'data' => $birdParent
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBirdParent()
    {
        try {
            $birdParent = BirdParent::all()->sortBy('ring_number');
            return response()->json(['data' => $birdParent], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBirdParentById($id)
    {
        try {
            $birdParent = BirdParent::find($id);
            return response()->json(['data' => $birdParent], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
