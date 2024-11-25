<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use Illuminate\Support\Facades\Auth;

class CurriculumController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        $rules = [
            'name_candidate' => 'sometimes|string|min:3|max:255',
            'email' => 'sometimes|string|email|max:255',
            'phone' => 'sometimes|string|min:9|max:11',
            'cep' => 'sometimes|string|min:8|max:9',
            'address' => 'sometimes|string|min:3|max:255',
            'state' => 'sometimes|string|min:2|max:2',
            'city' => 'sometimes|string|min:3|max:255',
            'company' => 'sometimes|string|min:3|max:255',
            'position' => 'sometimes|string|min:3|max:255',
            'is_currently_working' => 'sometimes|boolean',
            'start_date_work' => 'sometimes|date',
            'end_date_work' => 'sometimes|date|after_or_equal:start_date_work',
            'description_ativities' => 'sometimes|string|min:3|max:255',
            'formation' => 'sometimes|string|in:graduação,pos-graduação,mestrado,doutorado',
            'institution' => 'sometimes|string|min:3|max:255',
            'experience' => 'sometimes|string|min:3|max:255',
            'degree' => 'sometimes|string|in:tecnologo,licenciatura,bacharelado',
            'status' => 'sometimes|string|in:completo,em andamento,incompleto',
            'course' => 'sometimes|string|min:3|max:255',
            'start_date_course' => 'sometimes|date',
            'end_date_course' => 'sometimes|date|after_or_equal:start_date_course',
            'certificate_type' => 'sometimes|string|in:conquista,certificado',
            'certificate_title' => 'sometimes|string|min:3|max:255',
            'certificate_description' => 'sometimes|string|min:3|max:255',
            'certificate_institution' => 'sometimes|string|min:3|max:255',
            'soft_skills' => 'sometimes|string|min:3|max:255',
            'hard_skills' => 'sometimes|string|min:3|max:255',
            'language' => 'sometimes|string|min:3|max:255',
            'language_level' => 'sometimes|string|min:3|max:255',
            'curriculum_attachment' => 'sometimes|file|mimes:pdf,doc,docx|max:2048',
            'candidate_id' => 'sometimes|exists:candidates,id',
        ];

        $validatedData = $request->validate($rules);

        if ($request->hasFile('curriculum_attachment')) {
            $file = $request->file('curriculum_attachment');
            $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('file', $filename, 'public');
            $validatedData['curriculum_attachment'] = $filePath;
        }

        $validatedData['candidate_id'] = $user->id;

        $curriculum = Curriculum::create($validatedData);

        return response()->json([
            'message' => 'Currículo cadastrado com sucesso!',
            'curriculum' => $curriculum,
        ], 201);
    }

    public function show($id)
    {
        $curriculum = Curriculum::find($id);
        dd($curriculum);

        if (!$curriculum) {
            return response()->json(['message' => 'Currículo não encontrado.'], 404);
        }

        $user = Auth::user();
        if ($user->id !== $curriculum->candidate_id) {
            return response()->json(['message' => 'Acesso negado.'], 403);
        }

        return response()->json(['curriculum' => $curriculum]);

    }

    public function updateCurriculum(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        $curriculum = Curriculum::find($id);
        if (!$curriculum) {
            return response()->json(['message' => 'Currículo não encontrado.'], 404);
        }

        if ($user->id !== $curriculum->candidate_id) {
            return response()->json(['message' => 'Acesso negado.'], 403);
        }

        $rules = [
            'name_candidate' => 'sometimes|string|min:3|max:255',
            'email' => 'sometimes|string|email|max:255',
            'phone' => 'sometimes|string|min:9|max:11',
            'cep' => 'sometimes|string|min:8|max:9',
            'address' => 'sometimes|string|min:3|max:255',
            'state' => 'sometimes|string|min:2|max:2',
            'city' => 'sometimes|string|min:3|max:255',
            'company' => 'sometimes|string|min:3|max:255',
            'position' => 'sometimes|string|min:3|max:255',
            'is_currently_working' => 'sometimes|boolean',
            'start_date_work' => 'sometimes|date',
            'end_date_work' => 'sometimes|date|after_or_equal:start_date_work',
            'description_ativities' => 'sometimes|string|min:3|max:255',
            'formation' => 'sometimes|string|in:graduação,pos-graduação,mestrado,doutorado',
            'institution' => 'sometimes|string|min:3|max:255',
            'experience' => 'sometimes|string|min:3|max:255',
            'degree' => 'sometimes|string|in:tecnologo,licenciatura,bacharelado',
            'status' => 'sometimes|string|in:completo,em andamento,incompleto',
            'course' => 'sometimes|string|min:3|max:255',
            'start_date_course' => 'sometimes|date',
            'end_date_course' => 'sometimes|date|after_or_equal:start_date_course',
            'certificate_type' => 'sometimes|string|in:conquista,certificado',
            'certificate_title' => 'sometimes|string|min:3|max:255',
            'certificate_description' => 'sometimes|string|min:3|max:255',
            'certificate_institution' => 'sometimes|string|min:3|max:255',
            'soft_skills' => 'sometimes|string|min:3|max:255',
            'hard_skills' => 'sometimes|string|min:3|max:255',
            'language' => 'sometimes|string|min:3|max:255',
            'language_level' => 'sometimes|string|min:3|max:255',
            'curriculum_attachment' => 'sometimes|file|mimes:pdf,doc,docx|max:2048',
            'candidate_id' => 'sometimes|exists:candidates,id',
        ];

        $validatedData = $request->validate($rules);

        if ($request->hasFile('curriculum_attachment')) {
            $file = $request->file('curriculum_attachment');
            $path = $file->store('curriculums', 'public');
            $validatedData['curriculum_attachment'] = $path;
        }

        $curriculum->update($validatedData);

        return response()->json([
            'message' => 'Currículo atualizado com sucesso!',
            'curriculum' => $curriculum,
        ]);
    }
}
