<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecruiterController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados da requisição
        $arrayRequest = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:recruiters',
            'birthdate' => 'sometimes|date',
            'email' => 'required|email|unique:recruiters',
            'password' => 'required|string|min:8',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validação da foto
            'company_id' => 'required|exists:companies,id', // Validação do company_id
        ]);

        // Criptografa a senha
        $arrayRequest['password'] = Hash::make($arrayRequest['password']);

        // Se a foto foi enviada, faz o upload e armazena o caminho
        if ($request->hasFile('photo')) {
            // Armazenamento da foto
            $path = $request->file('photo')->store('photos', 'public');  // Armazena no diretório 'photos'
            $arrayRequest['photo'] = $path;  // Salva o caminho no banco
        }

        // Criação do recrutador com os dados validados
        $recruiter = Recruiter::create($arrayRequest);

        return response()->json([
            'message' => 'Recrutador criado com sucesso!',
            'recruiter' => $recruiter,
        ], 201);
    }

    public function loginRecruiter(Request $request)
    {
        // Verificação das credenciais
        $credentials = $request->only('email', 'password');

        // Tentativa de autenticação do recrutador
        if (Auth::guard('recruiter')->attempt($credentials)) {
            $recruiter = Auth::guard('recruiter')->user();
            $token = $recruiter->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Recrutador autenticado com sucesso!',
                'token' => $token,
                'recruiter' => $recruiter, // Retorna os dados do recrutador (caso seja necessário)
            ]);
        }

        // Retorno caso a autenticação falhe
        return response()->json(['message' => 'Falha na autenticação do recrutador'], 401);
    }
}
