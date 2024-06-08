<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function getStatus()
    {
        try {
            $status = Status::all()->map(function ($status) {
                return [
                    'id' => $status->id,
                    'parent_status' => $status->parent_status
                ];
            });

            if ($status->count() > 0) {
                return response()->json([
                    'status' => 200,
                    'data' => $status,
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No status found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getStatusById($id)
    {
        try {
            $status = Status::find($id);
            if ($status) {
                return response()->json([
                    'status' => 200,
                    'data' => $status
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Status not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createStatus(Request $request)
    {
        try {
            $status = new Status();
            $status->parent_status = $request->parent_status;
            $status->save();

            return response()->json([
                'status' => 200,
                'message' => 'Status created successfully',
                'data' => $status
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
