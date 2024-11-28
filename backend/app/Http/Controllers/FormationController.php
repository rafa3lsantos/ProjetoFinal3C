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

        $formation = Formation::create($arrayRequest);

        return response()->json([
            'message' => 'Formation registered successfully',
            'formation' => $formation,
        ], 201); // Código 201 para criação bem-sucedida
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
