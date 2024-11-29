<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Http\Controllers\Auth;

class FormationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'formation' => 'required|string|in:graduação,pos-graduação,mestrado,doutorado',
            'institution' => 'required|string',
            'experience' => 'nullable|string',
            'degree' => 'required|string|in:tecnologo,licenciatura,bacharelado',
            'status' => 'required|string|in:completo,em andamento,incompleto',
            'course' => 'required|string',
            'start_date_course' => 'required|date',
            'end_date_course' => 'nullable|date',
            'certificate_type' => 'nullable|string|in:conquista, certificado',
            'certificate_title' => 'nullable|string',
            'certificate_description' => 'nullable|string',
            'certificate_institution' => 'nullable|string',
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        try {

            $formation = Formation::create([
                'formation' => $validatedData['formation'],
                'institution' => $validatedData['institution'],
                'degree' => $validatedData['degree'],
                'status' => $validatedData['status'],
                'course' => $validatedData['course'],
                'start_date_course' => $validatedData['start_date_course'],
                'end_date_course' => $validatedData['end_date_course'] ?? null,
                'certificate_type' => $validatedData['certificate_type'] ?? null,
                'certificate_title' => $validatedData['certificate_title'] ?? null,
                'certificate_description' => $validatedData['certificate_description'] ?? null,
                'certificate_institution' => $validatedData['certificate_institution'] ?? null,
                'candidate_id' => $validatedData['candidate_id'],
            ]);


            return response()->json($formation, 201);
        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Erro ao salvar a formação. Tente novamente mais tarde.',
                'message' => $e->getMessage()
            ], 500);
        }
    }


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

    public function index($candidateId)
    {
        $formations = Formation::where('candidate_id', $candidateId)->get()->map(function ($formation) {
            return [
                'id' => $formation->id,
                'formation' => $formation->formation,
                'institution' => $formation->institution,
                'experience' => $formation->experience,
                'degree' => $formation->degree,
                'status' => $formation->status,
                'course' => $formation->course,
                'start_date_course' => $formation->start_date_course,
                'end_date_course' => $formation->end_date_course,
                'certificate_type' => $formation->certificate_type,
                'certificate_title' => $formation->certificate_title,
                'certificate_description' => $formation->certificate_description,
                'certificate_institution' => $formation->certificate_institution,
            ];
        });

        return response()->json([
            'formations' => $formations,
        ], 200);
    }
}
