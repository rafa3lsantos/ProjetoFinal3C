<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jobs;
use App\Models\Candidate;
use App\Models\Applications;

class ApplicationsController extends Controller
{
    public function applicationToJob(Request $request, $jobsId)
    {
        $jobs = Jobs::find($jobsId);
        if (!$jobs) {
            return response()->json([
                'message' => 'Não foi possível encontrar a vaga!',
            ], 404);
        }

        $candidate = Auth::guard('candidate')->user();
        if(!$candidate) {
            return response()->json(['message' => 'Candidato não encontrado ou não autenticado'], 401);
        }

        $existingApplication = Applications::where('candidate_id', $candidate->id)
                                            ->where('job_id', $jobsId)
                                            ->first();
        if ($existingApplication) {
            return response()->json(['message' => 'Você já se candidatou para esta vaga'], 409);
        }

        $application = Applications::create([
            'job_id' => $jobsId,
            'candidate_id' => $candidate->id,
            'appliaction_date' => now(),
        ]);

        return response()->json([
            'message' => 'Aplicação criada com sucesso!',
            'application' => $application,
        ], 201);
    }

    public function viewCandidate($jobsId)
    {
        $recruiter = Auth::guard('recruiter')->user();
        $job = Jobs::where('id', $jobsId)->where('recruiter_id', $recruiter->id)->first();

        if (!$job) {
            return response()->json([
                'message' => 'Não foi possível encontrar o emprego!',
            ], 404);
        }

        $candidates = $job->applications()->with('candidate')->get();

        return response()->json([
            'message' => 'Lista de candidatos encontrados com sucesso!',
            'candidates' => $candidates,
        ], 200);
    }
}
