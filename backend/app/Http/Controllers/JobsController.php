<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class JobsController extends Controller
{
    public function store(Request $request)
    {
        $recruiter = Auth::user();

        if (!$recruiter) {
            return response()->json([
                'message' => 'Ação não autorizada. Faça login como recrutador.',
            ], 403);
        }

        $arrayRequest = $request->validate([
            'title' => 'required|string|max:255',
            'work_model' => 'required|string|in:presential,remote,hybrid',
            'job_type' => 'required|string|in:effective,freelancer,temporary,internship',
            'jobs_state' => 'required|string|max:255',
            'jobs_city' => 'required|string|max:255',
            'jobs_status' => 'sometimes|string|in:in_progress, under_review, finished',
            'jobs_description' => 'required|string',
        ]);


        $arrayRequest['company_id'] = $recruiter->company_id;
        $arrayRequest['recruiter_id'] = $recruiter->id;

        $jobs = Jobs::create($arrayRequest);

        return response()->json([
            'message' => 'Emprego criado com sucesso!',
            'jobs' => $jobs,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $recruiter = Auth::user();

        if (!$recruiter) {
            return response()->json([
                'message' => 'Ação não autorizada. Faça login como recrutador.',
            ], 403);
        }

        $job = Jobs::where('id', $id)->where('company_id', $recruiter->company->id)->first();

        if (!$job) {
            return response()->json([
                'message' => 'Vaga não encontrada.',
            ], 404);
        }

        $arrayRequest = $request->validate([
            'title' => 'nullable|string|max:255',
            'work_model' => 'nullable|string|in:presential,remote,hybrid',
            'job_type' => 'nullable|string|in:effective,freelancer,temporary,internship',
            'jobs_state' => 'nullable|string|max:255',
            'jobs_city' => 'nullable|string|max:255',
            'jobs_status' => 'nullable|string|in:in_progress,under_review,finished',
            'jobs_description' => 'nullable|string',
        ]);

        $job->update($arrayRequest);

        return response()->json([
            'message' => 'Emprego atualizado com sucesso!',
            'jobs' => $job,
        ], 200);
    }

    public function show($id)
    {

        $jobs = Jobs::with('company')->find($id);

        if (!$jobs) {
            return response()->json([
                'message' => 'Não foi possível encontrar o emprego!',
            ], 404);
        }

        return response()->json([
            'message' => 'Emprego encontrado com sucesso!',
            'jobs' => $jobs,
            'company_name' => $jobs->company->name ?? 'Empresa não cadastrada',
        ], 200);
    }

    public function indexForCandidates()
    {
        $jobs = Jobs::with('company')
            ->where('jobs_status', 'in_progress')
            ->orWhere('jobs_status', 'under_review')
            ->get();

        if ($jobs->isEmpty()) {
            return response()->json([
                'message' => 'Não há vagas disponíveis!',
            ], 404);
        }

        return response()->json([
            'message' => 'Vagas disponíveis!',
            'jobs' => $jobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'work_model' => $job->work_model,
                    'job_type' => $job->job_type,
                    'jobs_state' => $job->jobs_state,
                    'jobs_city' => $job->jobs_city,
                    'jobs_status' => $job->jobs_status,
                    'jobs_description' => $job->jobs_description,
                    'company_name' => $job->company ? $job->company->name : 'Empresa não cadastrada',
                ];
            }),
        ], 200);
    }


    public function indexForRecruiters()
    {
        $jobs = Jobs::with('company')
            ->where('recruiter_id', Auth::id())
            ->get();

        if ($jobs->isEmpty()) {
            return response()->json([
                'message' => 'Você não criou nenhuma vaga!',
            ], 404);
        }

        return response()->json([
            'message' => 'Vagas encontradas!',
            'jobs' => $jobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'work_model' => $job->work_model,
                    'job_type' => $job->job_type,
                    'jobs_state' => $job->jobs_state,
                    'jobs_city' => $job->jobs_city,
                    'jobs_status' => $job->jobs_status,
                    'jobs_description' => $job->jobs_description,
                    'company_name' => $job->company ? $job->company->name : 'Empresa não cadastrada',
                ];
            }),
        ], 200);
    }

    public function indexInProgress()
    {
        $jobs = Jobs::with('company')
            ->whereIn('jobs_status', ['in_progress', 'under_review'])
            ->get();

        if ($jobs->isEmpty()) {
            return response()->json([
                'message' => 'Não há vagas em andamento!',
                'jobs' => [],
            ], 200);
        }

        return response()->json([
            'message' => 'Vagas em andamento!',
            'jobs' => $jobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'work_model' => $job->work_model,
                    'job_type' => $job->job_type,
                    'jobs_state' => $job->jobs_state,
                    'jobs_city' => $job->jobs_city,
                    'jobs_status' => $job->jobs_status,
                    'jobs_description' => $job->jobs_description,
                    'company_name' => $job->company ? $job->company->name : 'Empresa não cadastrada',
                ];
            }),
        ], 200);
    }
}
