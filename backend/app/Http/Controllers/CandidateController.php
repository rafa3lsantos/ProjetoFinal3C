<?php

namespace App\Http\Controllers;

use App\Models\candidate;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'cpf' => 'required|string|min:11|max:14|unique:candidates',
            'email' => 'required|string|email|min:3|max:255|unique:candidates',
            'password' => 'required|string|min:6|max:255',
            'phone' => 'nullable|string|min:11|max:14|unique:candidates',
            'gender' => 'nullable|string|in:masculino,feminino,nao-binario,outro',
            'cep' => 'nullable|string|min:8|max:9',
            'address' => 'nullable|string|min:3|max:255',
            'state' => 'nullable|string|min:2|max:255',
            'city' => 'nullable|string|min:3|max:255',
            'language' => 'nullable|string|min:3|max:255',
            'curriculum' => 'nullable|string|min:3|max:255',
        ]);

        $candidate = Candidate::create($arrayRequest);



        
        return response()->json([
            'message' => "cadastrado com sucesso!",
            'candidate'=> $candidate
        ]);

    }

    public function loginCandidate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('candidate')->attempt($credentials)) {
            $candidate = Auth::guard('candidate')->user();
            $token = $candidate->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'candidato autenticado com sucesso!',
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Falha na autenticação do candidatio'], 401);
    }

}
