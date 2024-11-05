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
            'job_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ]);

        $job = Jobs::create($arrayRequest);

        return response()->json([
            'message' => 'Emprego criado com sucesso!',
            'job' => $job,
        ], 201);
    }
}
