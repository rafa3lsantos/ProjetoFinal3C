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
        $arrayRequest = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:recruiters',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:recruiters',
            'password' => 'required|string|min:8',
            'company_id' => 'required|exists:companies,id',
        ]);

        // Hash a senha antes de salvar
        $arrayRequest['password'] = Hash::make($arrayRequest['password']);

        $recruiter = Recruiter::create($arrayRequest);

        return response()->json([
            'message' => 'Recrutador criado com sucesso!',
            'recruiter' => $recruiter,
        ], 201); 
    }


    public function loginRecruiter(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('recruiter')->attempt($credentials)) {
            $recruiter = Auth::guard('recruiter')->user();
            $token = $recruiter->createToken('auth_token')->plainTextToken; 

            return response()->json([
                'message' => 'Recrutador autenticado com sucesso!',
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Falha na autenticação do recrutador'], 401);
    }

}
