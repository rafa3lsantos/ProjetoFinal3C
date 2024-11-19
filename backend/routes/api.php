<?php

use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\ApplicationsController;
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

Route::post('candidate/login', [CandidateController::class, 'loginCandidate']);
Route::post('candidate/register', [CandidateController::class, 'store']);

Route::middleware(['auth:sanctum', 'role:candidate'])->prefix('candidate')->group(function () {
    Route::put('update/{id}', [CandidateController::class, 'updateCandidate']);
    Route::post('jobs/{jobId}/apply', [ApplicationsController::class, 'applicationToJob']); // Candidatar-se a uma vaga
});

Route::prefix('recruiter')->group(function () {
    Route::post('login', [RecruiterController::class, 'loginRecruiter']);
    Route::get('show/{id}', [RecruiterController::class, 'show']);
    
    Route::middleware(['auth:sanctum', 'role:company'])->group(function () {
        Route::post('register', [RecruiterController::class, 'store']);
    });

    Route::middleware(['auth:sanctum', 'role:recruiter'])->group(function () {
        Route::put('update/{id}', [RecruiterController::class, 'update']);
        Route::get('applications/{jobId}/candidates', [ApplicationsController::class, 'viewCandidate']); // Ver candidatos de uma vaga
    });
});

Route::prefix('company')->group(function () {
    Route::post('register', [CompanyController::class, 'store']);
    Route::post('login', [CompanyController::class, 'loginCompany']);
    Route::get('show/{id}', [CompanyController::class, 'show']);

    Route::middleware(['auth:sanctum', 'role:company'])->group(function () {
        Route::put('update/{id}', [CompanyController::class, 'update']);
    });
});

Route::prefix('jobs')->middleware(['auth:sanctum', 'role:recruiter'])->group(function () {
    Route::post('register', [JobsController::class, 'store']);
    Route::put('update/{id}', [JobsController::class, 'update']);
});
