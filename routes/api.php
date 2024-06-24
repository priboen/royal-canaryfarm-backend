<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\BirdParentController;
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\Feed\ProfileController;
use App\Http\Controllers\PedigreeController;
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

    //indukan
    Route::post('/addcanary', [BirdParentController::class, 'addBirds']);
    // Route::get('/canary-list', [BirdParentController::class, 'getBirds']);
    // Route::get('/canary-list/{gender}', [BirdParentController::class, 'getBirdsByGender']);
    Route::post('/addPedigree', [PedigreeController::class, 'addPedigree']);

    //anak
    // Route::post('/addPedigree', [BirdParentController::class, 'addPedigree']);

    // Route::get('/canary-list', [BirdParentController::class, 'getBirds']);
    // Route::get('/canary-list/{id}/{gender}', [BirdParentController::class, 'getBirdsByGender']);
    Route::get('/canary-list/{gender?}', [BirdParentController::class, 'getBirdsById']);
    Route::get('/canary-list', [BirdParentController::class, 'fetchBirds']);
    // Route::get('/canary-list/{breeder_id}/{gender}', [BirdParentController::class, 'getBirdsById']);

    //profile
    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::get('/profile/{id}', [ProfileController::class, 'getProfileById']);
});



// Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'getProfile']);




// Route::post('/register', [AuthenticationController::class, 'register']);

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

// Route::post('/addcanary', [BirdParentController::class, 'addBirds']);

Route::get('/status', [StatusController::class, 'getStatus']);
Route::get('/status/{id}', [StatusController::class, 'getStatusById']);
Route::post('/addStatus', [StatusController::class, 'createStatus']);
