<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use Illuminate\Support\Facades\Auth;;

class CurriculumController extends Controller
{
    public function store(Request $request)
    {
        // Verificar se o usuário está autenticado
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Usuário não autenticado.'
            ], 401);  // Retorna 401 Unauthorized
        }

        // Regras de validação
        $rules = [
            'cep' => 'required',
            'address' => 'required|string|min:3|max:255',
            'state' => 'required|string|min:2|max:2',
            'city' => 'required|string|min:3|max:255',
            'formation' => 'required|string|in:graduação,pos-graduação,mestrado,doutorado',
            'institution' => 'required|string|min:3|max:255',
            'experience' => 'required|string|min:3|max:255',
            'degree' => 'required|string|in:tecnologo,licenciatura,bacharelado',
            'status' => 'required|string|in:completo,em andamento,incompleto',
            'course' => 'required|string|min:3|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'certificate_type' => 'required|string|in:conquista,certificado',
            'certificate_title' => 'required|string|min:3|max:255',
            'certificate_description' => 'required|string|min:3|max:255',
            'certificate_institution' => 'required|string|min:3|max:255',
            'soft_skills' => 'required|string|min:3|max:255',
            'hard_skills' => 'required|string|min:3|max:255',
            'language' => 'required|string|min:3|max:255',
            'language_level' => 'required|string|min:3|max:255',
            'curriculum_attachment' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ];

        $validatedData = $request->validate($rules);

        if ($request->hasFile('curriculum_attachment')) {
            // Armazenar o arquivo
            $validatedData['curriculum_attachment'] = $request->file('curriculum_attachment')->store('attachments');
        }

        $validatedData['candidate_id'] = $user->id;

        //cria o curriculo
        $curriculum = Curriculum::create($validatedData);

        // Retornar resposta
        return response()->json([
            'message' => 'Currículo cadastrado com sucesso!',
            'curriculum' => $curriculum,
        ], 201);
    }

    public function show($id)
    {
        $curriculum = Curriculum::find($id);

        if (!$curriculum) {
            return response()->json([
                'message' => 'Currículo não encontrado.'
            ], 404);
        }

        $user = Auth::user();
        if ($user->id !== $curriculum->candidate_id) {
            return response()->json([
                'message' => 'Acesso negado.'
            ], 403);
        }

        return response()->json([
            'curriculum' => $curriculum
        ]);
    }
}
