<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;
use App\Models\Applications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class JobsController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'title' => 'required|string|max:255',
            'work_model' => 'required|string|in:presential,remote,hybrid',
            'job_type' => 'required|string|in:effective,freelancer,temporary,internship',
            'jobs_state' => 'required|string|max:255',
            'jobs_city' => 'required|string|max:255',
            'jobs_status' => 'required|string|max:255',
            'jobs_description' => 'required|string',
            'company_id' => 'required|exists:companies,id',
        ]);        

        $jobs = Jobs::create($arrayRequest);

        return response()->json([
            'message' => 'Emprego criado com sucesso!',
            'jobs' => $jobs,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $arrayRequest = $request->validate([
            'title' => 'nullable|string|max:255',
            'work_model' => 'nullable|string|in:presential,remote,hybrid',
            'job_type' => 'nullable|string|in:effective,freelancer,temporary,internship',
            'jobs_state' => 'nullable|string|max:255',
            'jobs_city' => 'nullable|string|max:255',
            'jobs_status' => 'nullable|string|max:255',
            'jobs_description' => 'nullable|string',
        ]);
    
        $job = Jobs::find($id);
    
        if (!$job) {
            return response()->json([
                'message' => 'Vaga não encontrada.',
            ], 404);
        }
    
        $recruiter = Auth::guard('recruiter')->user();
    
        if ($job->company_id !== $recruiter->company_id) {
            return response()->json([
                'message' => 'Você não tem permissão para atualizar esta vaga.',
            ], 403);
        }
    
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
}
