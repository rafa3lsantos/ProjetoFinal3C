<?php

use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\CandidateController;
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

Route::prefix('candidate')->group(function () {
    Route::post('/register', [CandidateController::class, 'store']);
    Route::post('/login', [CandidateController::class, 'login']);
});

Route::prefix('recruiter')->group(function () {
    Route::post('/register', [RecruiterController::class, 'store']);
    Route::post('/login', [RecruiterController::class, 'loginRecruiter']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/skill', 'App\Http\Controllers\SkillController@store');
