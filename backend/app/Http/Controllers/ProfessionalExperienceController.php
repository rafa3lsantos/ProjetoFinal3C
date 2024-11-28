<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfessionalExperience;
use Illuminate\Support\Facades\Auth;

class ProfessionalExperienceController extends Controller
{

    public function store(Request $request){

        $candidate = Auth::user();

        if(!$candidate){
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

        $professionalExperience = ProfessionalExperience::create($arrayRequest);

        return response()->json([
            'message' => 'Professional experience registered successfully',
            'professionalExperience' => $professionalExperience
        ]);
    }

    public function update(Request $request, $id){

        $candidate = Auth::user();

        if(!$candidate){
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

    public function show(){

        $candidate = Auth::user();

        if(!$candidate->professionalExperience){
            return response()->json(['error' => 'Professional experience not registered'], 401);
        }

        return response()->json([
            'professionalExperience' => $candidate->professionalExperience
        ]);
    }
}
