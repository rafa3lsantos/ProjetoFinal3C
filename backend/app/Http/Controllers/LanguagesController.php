<?php

namespace App\Http\Controllers;

use App\Models\Languages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public function store(Request $request)
    {
        $candidate = auth()->user();

        if (!$candidate) {
            return response()->json(['message' => 'Você não tem permissão para realizar esta operação'], 401);
        }

        $arrayRequest = $request->validate([
            'language' => 'required|string',
            'level' => 'required|string|in:beginner,intermediate,advanced,fluent',
        ]);

        $arrayRequest['candidate_id'] = $candidate->id;

        $language = Languages::create($arrayRequest);

        return response()->json([
            'message' => 'Idioma adicionado com sucesso!',
            'language' => $language,
            'candidate_id' => $candidate->id,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $candidate = auth()->user();

        if (!$candidate) {
            return response()->json(['message' => 'Você não tem permissão para realizar esta operação'], 401);
        }

        $language = Languages::where('id', $id)->where('candidate_id', $candidate->id)->first();

        if (!$language) {
            return response()->json([
                'message' => 'Idioma não encontrado.',
            ], 404);
        }

        $arrayRequest = $request->validate([
            'language' => 'nullable|string',
            'level' => 'nullable|string|in:beginner,intermediate,advanced,fluent',
        ]);

        $language->update($arrayRequest);

        return response()->json([
            'message' => 'Idioma atualizado com sucesso!',
            'language' => $language,
            'candidate_id' => $candidate->id,
        ], 200);
    }

    public function show($id)
    {
        $language = Languages::find($id);

        if (!$language) {
            return response()->json([
                'message' => 'Idioma não encontrado.',
            ], 404);
        }

        return response()->json([
            'message' => 'Idioma encontrado com sucesso!',
            'language' => $language,
            'candidate_id' => $language->candidate_id,
        ], 200);
    }
}
