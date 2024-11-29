<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfessionalExperience;
use Illuminate\Support\Facades\Auth;

class ProfessionalExperienceController extends Controller
{
    public function store(Request $request)
    {
        $candidate = Auth::user();

        if (!$candidate) {
            return response()->json(['error' => 'Candidato não autenticado'], 401);
        }

        // Validação da requisição
        $arrayRequest = $request->validate([
            'company' => 'sometimes|string',
            'position' => 'sometimes|string',
            'is_currently_working' => 'sometimes|boolean',
            'start_date_work' => 'sometimes|date',
            'end_date_work' => 'sometimes|date|after_or_equal:start_date_work',
            'description_ativities' => 'sometimes|string',
        ]);

        // Criar a experiência profissional com o ID do candidato autenticado
        $arrayRequest['candidate_id'] = $candidate->id;
        $professionalExperience = ProfessionalExperience::create($arrayRequest);

        return response()->json([
            'message' => 'Professional experience registered successfully',
            'professionalExperience' => $professionalExperience
        ]);
    }

    public function update(Request $request, $id)
    {
        $candidate = Auth::user();

        if (!$candidate) {
            return response()->json(['error' => 'Candidato não autenticado'], 401);
        }

        // Verificar se a experiência profissional existe
        $professionalExperience = ProfessionalExperience::find($id);
        if (!$professionalExperience) {
            return response()->json(['error' => 'Professional experience not found'], 404);
        }

        // Validação da requisição
        $arrayRequest = $request->validate([
            'company' => 'sometimes|string',
            'position' => 'sometimes|string',
            'is_currently_working' => 'sometimes|boolean',
            'start_date_work' => 'sometimes|date',
            'end_date_work' => 'sometimes|date|after_or_equal:start_date_work',
            'description_ativities' => 'sometimes|string',
        ]);

        // Atualizar a experiência profissional
        $professionalExperience->update($arrayRequest);

        return response()->json([
            'message' => 'Professional experience updated successfully',
            'professionalExperience' => $professionalExperience
        ]);
    }

    public function show($id)
    {
        $professionalExperience = ProfessionalExperience::find($id);

        if (!$professionalExperience) {
            return response()->json(['error' => 'Experiência profissional não encontrada'], 404);
        }

        return response()->json([
            'professionalExperience' => $professionalExperience,
        ]);
    }

}


