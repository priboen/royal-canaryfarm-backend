<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\Feed\ProfileController;
use App\Http\Controllers\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/chicks', [FeedController::class, 'addFeed']);
    Route::get('/chicks', [FeedController::class, 'getFeed']);
    Route::get('/profile', [ProfileController::class, 'getProfile']);
});

// Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'getProfile']);

// Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::get('/status', [StatusController::class, 'getStatus']);
Route::get('/status/{id}', [StatusController::class, 'getStatusById']);
Route::post('/addStatus', [StatusController::class, 'createStatus']);
