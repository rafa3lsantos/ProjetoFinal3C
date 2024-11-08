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
            'birthdate' => 'sometimes|date',
            'email' => 'required|email|unique:recruiters',
            'password' => 'required|string|min:8',
            'photo' => 'sometimes|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ]);

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

    public function update(Request $request, $id){
        $arrayRequest = $request->validate([
            'name' => 'nullable|string|max:255',
            'cpf' => 'nullable|string|max:14',
            'birthdate' => 'nullable|date',
            'email' => 'nullable|email',
            'password' => 'nullable|string|min:8',
            'photo' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        $recruiter = Recruiter::find($id);

        $arrayRequest['password'] = Hash::make($arrayRequest['password']);

        $recruiter->update($arrayRequest);

        return response()->json([
            'message' => 'Recrutador atualizado com sucesso!',
            'recruiter' => $recruiter,
        ], 201);
    }
}
