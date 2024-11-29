<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfessionalExperience;
use Illuminate\Support\Facades\Auth;

class ProfessionalExperienceController extends Controller
{

    public function store(Request $request)
    {

        $request->validate([
            'company' => 'required|string',
            'position' => 'required|string',
            'start_date_work' => 'required|date',
            'end_date_work' => 'nullable|date',
            'is_currently_working' => 'required|boolean',
            'description_ativities' => 'nullable|string',
        ]);

        try {

            $candidate = Auth::user();

            if (!$candidate) {
                return response()->json(['error' => 'Candidato não autenticado'], 401);
            }


            $data = $request->all();


            if ($data['is_currently_working']) {
                $data['end_date_work'] = null;
            }

            $professionalExperience = ProfessionalExperience::create([
                'company' => $data['company'],
                'position' => $data['position'],
                'start_date_work' => $data['start_date_work'],
                'end_date_work' => $data['end_date_work'],
                'is_currently_working' => $data['is_currently_working'],
                'description_ativities' => $data['description_ativities'] ?? null,
                'candidate_id' => $candidate->id,
            ]);

            return response()->json([
                'message' => 'Experiência profissional registrada com sucesso.',
                'professionalExperience' => $professionalExperience
            ]);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Erro no servidor: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $candidate = Auth::user();

        if (!$candidate) {
            return response()->json(['error' => 'Candidato não autenticado'], 401);
        }

        $arrayRequest = $request->validate([
            'company' => 'sometimes|string',
            'position' => 'sometimes|string',
            'is_currently_working' => 'sometimes|boolean',
            'start_date_work' => 'sometimes|date',
            'end_date_work' => 'sometimes|date',
            'description_ativities' => 'sometimes|string',
        ]);

        $professionalExperience = ProfessionalExperience::find($id);

        $professionalExperience->update($arrayRequest);

        return response()->json([
            'message' => 'Professional experience updated successfully',
            'professionalExperience' => $professionalExperience
        ]);
    }

    public function index()
    {
        $candidate = Auth::user();

        if (!$candidate) {
            return response()->json([
                'error' => 'Usuário não autenticado.',
            ], 401);
        }

        $experiences = $candidate->professionalExperience->map(function ($experience) {
            return [
                'id' => $experience->id,
                'job_title' => $experience->position,
                'company_name' => $experience->company,
                'start_date' => $experience->start_date_work,
                'end_date' => $experience->end_date_work,
                'description' => $experience->description_ativities,
            ];
        });

        return response()->json([
            'professionalExperiences' => $experiences,
        ], 200);
    }
}
