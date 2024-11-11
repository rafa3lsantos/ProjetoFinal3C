<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'name_company' => 'required|string|max:255',
            'cnpj_company' => 'required|string|max:14|unique:companies',
            'email_company' => 'required|email|unique:companies',
            'password_company' => 'required|string|min:8',
            'photo_company' => 'sometimes|string|max:255',
            'company_sector' => 'nullable|string|max:255',
            'about_company' => 'nullable|string|max:255',

        ]);

        $arrayRequest['password_company'] = Hash::make($arrayRequest['password_company']);

        $company = Company::create($arrayRequest);

        return response()->json([
            'message' => 'Empresa criada com sucesso!',
            'company' => $company,
        ], 201);
    }

    public function loginCompany(Request $request)
    {
        $credentials = $request->only('email_company', 'password_company');
        if (Auth::guard('company')->attempt($credentials)) {
            $company = Auth::guard('company')->user();

            $token = $company->createToken('auth_token')->plainTextToken; 

            return response()->json([
                'message' => 'Empresa autenticada com sucesso!',
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Falha na autenticação da empresa'], 401);
    }

    public function update(Request $request, $id){
        $arrayRequest = $request->validate([
            'name_company' => 'nullable|string|max:255',
            'cnpj_company' => 'nullable|string|max:14',
            'email_company' => 'nullable|email',
            'password_company' => 'nullable|string|min:8',
            'photo_company' => 'nullable|string|max:255',
            'company_sector' => 'nullable|string|max:255',
            'about_company' => 'nullable|string|max:255',
        ]);

        $company = Company::find($id);

        $arrayRequest['password_company'] = Hash::make($arrayRequest['password_company']);

        $company->update($arrayRequest);

        return response()->json([
            'message' => 'Empresa atualizada com sucesso!',
            'company' => $company,
        ], 201);
    }

    public function show($id){
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }

        return response()->json([
            'message' => 'Empresa encontrada com sucesso!',
            'company' => $company,
        ], 200);
    }
}
