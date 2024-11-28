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
        'formation' => 'required|string',
        'institution' => 'required|string',
        'experience' => 'required|string',
        'degree' => 'required|string',
        'status' => 'required|string',
        'course' => 'required|string',
        'start_date_course' => 'required|date',
        'end_date_course' => 'nullable|date',
        'certificate_type' => 'nullable|string',
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

        $arrayRequest = $request->validate([
            'formation' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'experience' => 'required|string|max:500',
            'degree' => 'required|string|in:tecnologo,licenciatura,bacharelado',
            'status' => 'required|string|in:completo,em andamento,incompleto',
            'course' => 'required|string|max:255',
            'start_date_course' => 'required|date',
            'end_date_course' => 'required|date|after_or_equal:start_date_course',
            'certificate_type' => 'required|string|in:conquista,certificado',
            'certificate_title' => 'required|string|max:255',
            'certificate_description' => 'required|string|max:500',
            'certificate_institution' => 'required|string|max:255',
        ]);

        $formation->update($arrayRequest);

        return response()->json([
            'message' => 'Formation updated successfully',
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
