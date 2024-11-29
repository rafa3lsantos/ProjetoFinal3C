<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;

class FormationController extends Controller
{
    // Middleware para garantir autenticação (caso necessário)
    public function __construct()
    {
        $this->middleware('auth'); // Adicione isso se a autenticação for obrigatória
    }

    // Método para criar uma nova formação
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'formation' => 'required|string|in:graduação,pos-graduação,mestrado,doutorado',
            'institution' => 'required|string',
            'experience' => 'required|string',
            'degree' => 'required|string|in:tecnologo,licenciatura,bacharelado',
            'status' => 'required|string|in:completo, em andamento, incompleto',
            'course' => 'required|string',
            'start_date_course' => 'required|date',
            'end_date_course' => 'nullable|date',
            'certificate_type' => 'nullable|string|in:conquista, certificado',
            'certificate_title' => 'nullable|string',
            'certificate_description' => 'nullable|string',
            'certificate_institution' => 'nullable|string',
            'candidate_id' => 'required|exists:candidates,id', // Validação para candidate_id
        ]);

        $formation = Formation::create($validatedData);

        return response()->json($formation, 201);
    }

    // Método para atualizar uma formação existente
    public function update(Request $request, $id)
    {
        $formation = Formation::find($id);

        if (!$formation) {
            return response()->json(['error' => 'Formação não encontrada'], 404);
        }

        $validatedData = $request->validate([
            'formation' => 'sometimes|string|in:graduação,pos-graduação,mestrado,doutorado',
            'institution' => 'sometimes|string',
            'experience' => 'sometimes|string',
            'degree' => 'sometimes|string|in:tecnologo,licenciatura,bacharelado',
            'status' => 'sometimes|string|in:completo, em andamento, incompleto',
            'course' => 'sometimes|string',
            'start_date_course' => 'sometimes|date',
            'end_date_course' => 'nullable|date',
            'certificate_type' => 'nullable|string|in:conquista, certificado',
            'certificate_title' => 'nullable|string',
            'certificate_description' => 'nullable|string',
            'certificate_institution' => 'nullable|string',
        ]);

        $formation->update($validatedData);

        return response()->json([
            'message' => 'Formação atualizada com sucesso',
            'formation' => $formation,
        ]);
    }

    // Método para exibir uma formação específica
    public function show($id)
    {
        $formation = Formation::find($id);

        if (!$formation) {
            return response()->json(['error' => 'Formação não encontrada'], 404);
        }

        return response()->json([
            'formation' => $formation,
        ]);
    }
}
