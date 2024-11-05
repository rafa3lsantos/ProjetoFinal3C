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
            'cpf' => 'required|string|min:11|max:14|unique',
            'email' => 'required|string|email|min:3|max:255|unique',
            'password' => 'required|string|min:6|max:255',
            'phone'=> 'string|min:11|max:14|unique',
            'gender' => 'string|in:masculino,feminino,nao-binario,outro',
            'cep' => 'string|min:8|max:9',
            'address' => 'string|min:3|max:255',
            'state' => 'string|min:2|max:255',
            'city' => 'string|min:3|max:255',
            'language' => 'string|min:3|max:255',
            'curriculum' => 'string|min:3|max:255',

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
