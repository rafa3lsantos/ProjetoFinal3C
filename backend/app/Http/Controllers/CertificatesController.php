<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class CertificatesController extends Controller
{
    public function store(Request $request)
    {
        $candidate = auth()->user();

        if (!$candidate) {
            return response()->json(['message' => 'Você não tem permissão para realizar esta operação'], 401);
        }

        $arrayRequest = $request->validate([
            'tipo' => 'required|string|in:conquista,certificado',
            'titulo' => 'required|string',
            'descricao' => 'required|string',
        ]);

        $arrayRequest['candidate_id'] = $candidate->id;

        $certificate = Certificate::create($arrayRequest);

        return response()->json([
            'message' => 'Certificado adicionado com sucesso!',
            'certificate' => $certificate,
            'candidate_id' => $candidate->id,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $candidate = auth()->user();

        if (!$candidate) {
            return response()->json(['message' => 'Você não tem permissão para realizar esta operação'], 401);
        }

        $certificate = Certificate::where('id', $id)->where('candidate_id', $candidate->id)->first();

        if (!$certificate) {
            return response()->json([
                'message' => 'Certificado não encontrado.',
            ], 404);
        }

        $arrayRequest = $request->validate([
            'tipo' => 'nullable|string|in:conquista,certificado',
            'titulo' => 'nullable|string',
            'descricao' => 'nullable|string',
        ]);

        $certificate->update($arrayRequest);

        return response()->json([
            'message' => 'Certificado atualizado com sucesso!',
            'certificate' => $certificate,
            'candidate_id' => $candidate->id,
        ], 200);
    }

    public function show($id)
    {
        $certificate = Certificate::find($id);

        if (!$certificate) {
            return response()->json([
                'message' => 'Certificado não encontrado.',
            ], 404);
        }

        return response()->json([
            'message' => 'Certificado encontrado com sucesso!',
            'certificate' => $certificate,
            'candidate_id' => $certificate->candidate_id,
        ], 200);
    }
}
