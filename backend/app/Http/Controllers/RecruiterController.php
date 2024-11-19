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
            'recruiter_name' => 'required|string|max:255',
            'recruiter_cpf' => 'required|string|max:14|unique:recruiters',
            'recruiter_birthdate' => 'sometimes|date',
            'email' => 'required|email|unique:recruiters',
            'password' => 'required|string|min:8',
            'recruiter_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_id' => 'required|exists:companies,id',
        ]);

        $arrayRequest['password'] = Hash::make($arrayRequest['password']);

        if ($request->hasFile('recruiter_photo')) {
            $path = $request->file('recruiter_photo')->store('photos', 'public');
            $arrayRequest['recruiter_photo'] = $path;
        }

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
                'recruiter_id' => $recruiter->id,
            ]);
        }

        return response()->json(['message' => 'Falha na autenticação do recrutador'], 401);
    }

    public function update(Request $request, $id)
    {
        $recruiter = Auth::user();

        if (!$recruiter) {
            return response()->json([
                'message' => 'Ação não autorizada. Faça login como recrutador.',
            ], 403);
        }

        $recruiter = Recruiter::where('id', $id)->where('id', $recruiter->id)->first();


        $arrayRequest = $request->validate([
            'recruiter_name' => 'nullable|string|max:255',
            'recruiter_cpf' => 'nullable|string|max:14',
            'recruiter_birthdate' => 'nullable|date',
            'email' => 'nullable|email',
            'password' => 'sometimes|string|min:8',
            'recruiter_photo' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        if (isset($arrayRequest['password']) && !empty($arrayRequest['password'])) {
            $arrayRequest['password'] = Hash::make($arrayRequest['password']);
        } else {
            unset($arrayRequest['password']);
        }

        $recruiter->update($arrayRequest);

        return response()->json([
            'message' => 'Recrutador atualizado com sucesso!',
            'recruiter' => $recruiter,
        ], 201);
    }


    public function show($id)
    {
        $recruiter = Recruiter::find($id);

        if (!$recruiter) {
            return response()->json([
                'message' => 'Não foi possível encontrar o recrutador!',
            ], 404);
        }

        return response()->json([
            'message' => 'Recrutador encontrado com sucesso!',
            'recruiter' => $recruiter,
        ], 200);
    }
}
