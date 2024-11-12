<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;

class CandidateController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'name_candidate' => 'required|string|min:3|max:255',
            'cpf' => 'required|string|min:11|max:14|unique:candidates',
            'birth_date' => 'nullable|date',
            'email' => 'required|string|string|min:3|max:255|unique:candidates',
            'password' => 'required|string|min:6|max:255|confirmed',
            'password_confirmation' => 'required|string|min:6|max:255',
        ]);

        $arrayRequest['password'] = Hash::make($arrayRequest['password']);

        $candidate = Candidate::create($arrayRequest);

        return response()->json([
            'message' => 'Cadastrado com sucesso!',
            'candidate' => $candidate,
        ], 201);
    }
    public function loginCandidate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);


        if (Auth::guard('candidate')->attempt($credentials)) {
            $candidate = Auth::guard('candidate')->user();
            $token = $candidate->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Candidato autenticado com sucesso!',
                'token' => $token,
                'candidate_id' => $candidate->id,
            ], 200);
        }


        return response()->json(['message' => 'Falha na autenticação do candidato', 'error' => 'Credenciais inválidas'], 401);
    }
  
    public function updateCandidate(Request $request)
    {

        $candidate = Auth::user();

        if (!$candidate) {
            return response()->json(['message' => 'Candidato não encontrado ou não autenticado'], 401);
        }

        $arrayRequest = $request->validate([
            'name_candidate' => 'sometimes|string|min:3|max:255',
            'email' => 'sometimes|string|min:3|max:255|unique:candidates,email_candidate,' . $candidate->id,
            'password' => 'sometimes|string|min:6|max:255',
            'new_password' => 'sometimes|string|min:6|max:255|confirmed',
            'birth_date' => 'sometimes|date',
            'gender'=> 'sometimes|string|in:masculino,feminino,nao-binario,outro',
            'phone' => 'sometimes|string|min:11|max:14|unique:candidates,phone,' . $candidate->id,
            'cep' => 'sometimes|string|min:8|max:9',
            'address' => 'sometimes|string|min:3|max:255',
            'state' => 'sometimes|string|min:2|max:255',
            'city' => 'sometimes|string|min:3|max:255',
            'about_candidate' => 'sometimes|string|min:3|max:255',
            'photo' => 'sometimes|image',
        ]);

        if (isset($arrayRequest['new_password'])) {
            $arrayRequest['password'] = bcrypt($arrayRequest['new_password']);
            unset($arrayRequest['new_password']);
        }

        $candidate->update($arrayRequest);

        return response()->json(['message' => 'Candidato atualizado com sucesso'], 200);
    }



    public function logoutCandidate(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!',
        ], 200);
    }
}
