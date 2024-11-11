<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'cpf' => 'required|string|min:11|max:14|unique:candidates',
            'birth_date' => 'nullable|date',
            'email' => 'required|string|email|min:3|max:255|unique:candidates',
            'password' => 'required|string|min:6|max:255',
        ]);

        $arrayRequest['password'] = Hash::make($arrayRequest['password']);

        $candidate = Candidate::create($arrayRequest);

        return response()->json([
            'message' => 'Cadastrado com sucesso!',
            'candidate'=> $candidate,
        ], 201);
    }

    public function loginCandidate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('candidate')->attempt($credentials)) {
            $candidate = Auth::guard('candidate')->user();
            $token = $candidate->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Candidato autenticado com sucesso!',
                'token' => $token,
            ], 200);
        }

        return response()->json(['message' => 'Falha na autenticação do candidato'], 401);
    }

    public function updateCandidate(Request $request)
    {
        $candidate = $request->user();

        $arrayRequest = $request->validate([
            'name' => 'nullable|string|min:3|max:255',
            'email' => 'nullable|string|email|min:3|max:255|unique:candidates,email,' . $candidate->id,
            'password' => 'nullable|string|min:6|max:255',
            'birth_date' => 'nullable|date',
            'gender'=>  'nullable|string|in:masculino,feminino,nao-binario,outro',
            'phone' => 'nullable|string|min:11|max:14|unique:candidates,phone,' . $candidate->id,
            'cep' => 'nullable|string|min:8|max:9',
            'address' => 'nullable|string|min:3|max:255',
            'state' => 'nullable|string|min:2|max:255',
            'city' => 'nullable|string|min:3|max:255',  
            'about' => 'nullable|string|min:3|max:255',
            'photo'
        ]);
    }

    public function logoutCandidate(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!',
        ], 200);
    }
}
