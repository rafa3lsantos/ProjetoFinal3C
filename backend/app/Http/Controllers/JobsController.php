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
            'recruiter' => $recruiter,
            'company' => $recruiter->company->id,
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

        $job = Jobs::where('id', $id)->where('company_id', $recruiter->company->id)->first(); //Moacir que fez pa nois

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
            'jobs_status' => 'sometimes|string|in:in_progress, under_review, finished',
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
        $jobs = Jobs::find($id);

        if (!$jobs) {
            return response()->json([
                'message' => 'Não foi possível encontrar o emprego!',
            ], 404);
        }

        return response()->json([
            'message' => 'Emprego encontrado com sucesso!',
            'jobs' => $jobs,
        ], 200);
    }
    
    public function index(Request $request)
    {
        $recruiter = Auth::user();
    
        if (!$recruiter) {
            return response()->json([
                'message' => 'Ação não autorizada. Faça login como recrutador.',
            ], 403);
        }
    
        $jobs = Jobs::where('company_id', $recruiter->company_id)->get();
    
        return response()->json([
            'jobs' => $jobs,
        ], 200);
    }
}

