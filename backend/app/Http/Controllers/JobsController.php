<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'title' => 'required|string|max:255',
            'work_model' => 'required|string|in:presential,remote,hybrid',
            'job_type' => 'required|string|in:effective,freelancer,temporary,internship',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string', 
            'company_id' => 'required|exists:companies,id',
        ]);        

        $jobs = Jobs::create($arrayRequest);

        return response()->json([
            'message' => 'Emprego criado com sucesso!',
            'jobs' => $jobs,
        ], 201);
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
