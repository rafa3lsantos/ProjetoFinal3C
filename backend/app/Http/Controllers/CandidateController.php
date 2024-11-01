<?php

namespace App\Http\Controllers;

use App\Models\candidate;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Hash;

class CandidateController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'cpf' => 'required|string|min:11|max:14',
            'email' => 'required|string|email|min:3|max:255',
            'password' => 'required|string|min:6|max:255',
            'phone'=> 'required|string|min:11|max:14',
            'gender' => 'required|string|in:masculino,feminino,nao-binario,outro',
            'cep' => 'required|string|min:8|max:9',
            'address' => 'required|string|min:3|max:255',
            'state' => 'required|string|min:2|max:255',
            'city' => 'required|string|min:3|max:255',
            'language' => 'required|string|min:3|max:255',
            'curriculum' => 'required|string|min:3|max:255',

        ]);

        $candidate = Candidate::create($arrayRequest);

        return response()->json([
            'message' => "Candiatdo adicionado!",
            'candidate'=> $candidate
        ]);

    }

    public function login (Request $request)
    {
        $arrayRequest = $request->validate([
            'email' => 'required|string|email|min:3|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        $candidate = Candidate::where('email', $arrayRequest['email'])->first();
        $password = Candidate::where('password', $arrayRequest['password'])->first();

        if(!$candidate || !$password){
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }


        return response()->json([
            'message' => 'Login realizado com sucesso',
        ]);
    }

}
