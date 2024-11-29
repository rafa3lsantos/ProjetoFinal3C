<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skills;
use Illuminate\Support\Facades\Auth;

class SkillsController extends Controller
{
   public function store(Request $request)
   {
        $candidate = Auth::user();

        if(!$candidate) {            
           return response()->json(['message' => 'Você nao tem permissão para realizar esta operação'], 401);
        }

        $arrayRequest = $request->validate([
           'soft_skill' => 'required',
           'hard_skill' => 'required',
        ]);

        $arrayRequest['candidate_id'] = $candidate->id;

        $skill = Skills::create($arrayRequest);

        return response()->json([
            'message' => 'Skill adicionada com sucesso!',
            'skill' => $skill,
            'candidate_id' => $candidate->id,
        ], 201);
    }
    
    public function update(Request $request, $id)
    {
        $candidate = Auth::user();

        if(!$candidate) {            
           return response()->json(['message' => 'Você nao tem permissão para realizar esta operação'], 401);
        }

        $skill = Skills::where('id', $id)->where('candidate_id', $candidate->id)->first();

        if (!$skill) {
            return response()->json([
                'message' => 'Skill não encontrada.',
            ], 404);
        }

        $arrayRequest = $request->validate([
            'soft_skill' => 'nullable|string|max:255',
            'hard_skill' => 'nullable|string|max:255',
        ]);

        $skill->update($arrayRequest);

        return response()->json([
            'message' => 'Skill atualizada com sucesso!',
            'skill' => $skill,
            'candidate_id' => $candidate->id,
        ], 200);
    }

    public function show($id)
    {
        $skill = Skills::find($id);

        if (!$skill) {
            return response()->json([
                'message' => 'Skill não encontrada.',
            ], 404);
        }

        return response()->json([
            'message' => 'Skill encontrada com sucesso!',
            'skill' => $skill,
            'candidate_id' => $skill->candidate_id,
        ], 200);
    }
}
