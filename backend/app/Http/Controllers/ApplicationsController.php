<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jobs;
use App\Models\Candidate;
use App\Models\Applications;

class ApplicationsController extends Controller
{
    public function applyToJob(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:jobs,id',
        ]);

        $candidate = Auth::user();

        if (!$candidate) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $existingApplication = Applications::where('job_id', $validated['job_id'])
            ->where('candidate_id', $candidate->id)
            ->first();

        if ($existingApplication) {
            return response()->json(['message' => 'Você já se candidatou a esta vaga.'], 400);
        }

        $application = Applications::create([
            'job_id' => $validated['job_id'],
            'candidate_id' => $candidate->id,
            'status' => 'pending',
            'application_date' => now()
        ]);

        return response()->json([
            'message' => 'Candidatura realizada com sucesso!',
            'application' => $application,
        ], 201);
    }

    public function viewCandidates($jobId)
    {
        $recruiter = Auth::user();

        if (!$recruiter) {
            return response()->json([
                'message' => 'Ação não autorizada. Faça login como recrutador.',
            ], 403);
        }

        $job = Jobs::where('id', $jobId)
            ->where('recruiter_id', $recruiter->id)
            ->first();

        if (!$job) {
            return response()->json([
                'message' => 'Vaga não encontrada ou você não tem permissão para visualizá-la.',
            ], 404);
        }


        $candidateApplications = Applications::where('job_id', $jobId)
            ->with('candidate')
            ->get();

        if ($candidateApplications->isEmpty()) {
            return response()->json([
                'message' => 'Não há candidaturas cadastradas para esta vaga.',
            ], 404);
        }


        $candidates = $candidateApplications->pluck('candidate');

        return response()->json([
            'message' => 'Candidatos encontrados com sucesso!',
            'candidates' => $candidates,
        ], 200);
    }
}
