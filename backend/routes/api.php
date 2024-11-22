<?php

use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CurriculumController;
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

// -- Candidate Routes --

Route::post('candidate/login', [CandidateController::class, 'loginCandidate']);
Route::post('candidate/register', [CandidateController::class, 'store']);

Route::middleware(['auth:sanctum', 'role:candidate'])->group(function () {
    Route::prefix('candidate')->group(function () {
        Route::put('update/{id}', [CandidateController::class, 'updateCandidate']);
        Route::post('jobs/{jobId}/apply', [ApplicationsController::class, 'applicationToJob']);
        Route::put('/update/{id}', [CandidateController::class, 'updateCandidate']);
        Route::put('/update-password', [CandidateController::class, 'updatePassword']);
        Route::put('/update-email', [CandidateController::class, 'updateEmail']);
        Route::delete('/delete', [CandidateController::class, 'deleteCandidate']);
        Route::get('/show/{id}', [CandidateController::class, 'show']);
    });
});

// -- Curriculum Routes --

Route::middleware(['auth:sanctum', 'role:candidate'])->group(function () {
    Route::prefix('curriculum')->group(function () {
        Route::post('/register', [CurriculumController::class, 'store']);
        Route::put('/update/{id}', [CurriculumController::class, 'updateCurriculum']);
        Route::delete('/delete', [CurriculumController::class, 'delete']);
        Route::get('/show/{id}', [CurriculumController::class, 'show']);
    });
});

// -- Recruiter Routes --

Route::prefix('recruiter')->group(function () {
    Route::post('login', [RecruiterController::class, 'loginRecruiter']);
    Route::get('show/{id}', [RecruiterController::class, 'show']);

    Route::middleware(['auth:sanctum', 'role:company'])->group(function () {
        Route::post('register', [RecruiterController::class, 'store']);
    });

    Route::middleware(['auth:sanctum', 'role:recruiter'])->group(function () {
        Route::put('update/{id}', [RecruiterController::class, 'update']);
        Route::get('applications/{jobId}/candidates', [ApplicationsController::class, 'viewCandidate']);
    });
});

// -- Company Routes --

Route::prefix('company')->group(function () {
    Route::post('register', [CompanyController::class, 'store']);
    Route::post('login', [CompanyController::class, 'loginCompany']);
    Route::get('show/{id}', [CompanyController::class, 'show']);

    Route::middleware(['auth:sanctum', 'role:company'])->group(function () {
        Route::put('update/{id}', [CompanyController::class, 'update']);
    });
});

// -- Jobs Routes --

Route::prefix('jobs')->middleware(['auth:sanctum', 'role:recruiter'])->group(function () {
    Route::get('show', [JobsController::class, 'index']);
    Route::post('register', [JobsController::class, 'store']);
    Route::put('update/{id}', [JobsController::class, 'update']);
});

Route::get('jobs/show/{id}', [JobsController::class, 'show']);
