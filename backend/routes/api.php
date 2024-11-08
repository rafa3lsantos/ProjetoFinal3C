<?php

use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
    Route::post('/login', [CandidateController::class, 'loginCandidate']);
});

Route::middleware('auth:candidate')->group(function () {    
    //
});

Route::prefix('recruiter')->group(function () {
    Route::post('/register', [RecruiterController::class, 'store']);
    Route::post('/login', [RecruiterController::class, 'loginRecruiter']);
});

Route::middleware('auth:recruiter')->group(function () {
    //
});

Route::prefix('company')->group(function () {
    Route::post('/register', [CompanyController::class, 'store']);
    Route::post('/login', [CompanyController::class, 'loginCompany']);
});

Route::middleware('auth:company')->group(function () {
    //
});

Route::prefix('jobs')->middleware(['auth:sanctum', 'role:recruiter'])->group(function () {
    Route::post('/register', [JobsController::class, 'store']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/skill', 'App\Http\Controllers\SkillController@store');
