<?php

use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ProfessionalExperienceController;

use App\Http\Controllers\JobsController;
use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\CertificatesController;
use App\Http\Controllers\LanguagesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Can;

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
        Route::put('/update/{id}', [CandidateController::class, 'updateCandidate']);
        Route::put('/update-password', [CandidateController::class, 'updatePassword']);
        Route::put('/update-email', [CandidateController::class, 'updateEmail']);
        Route::delete('/delete', [CandidateController::class, 'deleteCandidate']);
        Route::get('/show/{id}', [CandidateController::class, 'show']);
        Route::post('/upload-profile-image', [CandidateController::class, 'uploadProfileImage']);
        Route::get('/profile-image/{id}', [CandidateController::class, 'getProfileImage']);
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
        Route::post('/upload-profile-image', [RecruiterController::class, 'uploadProfileImage']);
        Route::get('/profile-image/{id}', [RecruiterController::class, 'getProfileImage']);
    });
});

// -- Company Routes --

Route::prefix('company')->group(function () {
    Route::post('register', [CompanyController::class, 'store']);
    Route::post('login', [CompanyController::class, 'loginCompany']);
    Route::get('show/{id}', [CompanyController::class, 'show']);

    Route::middleware(['auth:sanctum', 'role:company'])->group(function () {
        Route::get('index-for-company', [CompanyController::class, 'indexForCompany']);
        Route::put('update/{id}', [CompanyController::class, 'update']);
        Route::post('upload-profile-image', [CompanyController::class, 'uploadProfileImage']);
        Route::get('/profile-image/{id}', [CompanyController::class, 'getProfileImage']);
    });
});

// -- Jobs Routes --

Route::prefix('jobs')->middleware(['auth:sanctum', 'role:recruiter'])->group(function () {
    Route::post('register', [JobsController::class, 'store']);
    Route::put('update/{id}', [JobsController::class, 'update']);
    Route::get('index', [JobsController::class, 'indexForRecruiters']);
});

Route::get('jobs/show/{id}', [JobsController::class, 'show']);
Route::get('jobs/show', [JobsController::class, 'show']);


Route::get('jobs/InProgress', [JobsController::class, 'indexInProgress']);


// -- Applications Routes --

Route::prefix('applications')->group(function () {
    Route::middleware(['auth:sanctum', 'role:candidate'])->group(function () {
        Route::post('/applyToJob', [ApplicationsController::class, 'applyToJob']);
    });
    Route::middleware(['auth:sanctum', 'role:recruiter'])->group(function () {
        Route::get('viewCandidates/{jobId}', [ApplicationsController::class, 'viewCandidates']);
    });
});

