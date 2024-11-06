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
            'name' => 'required|string|max:255',
            'cnpj' => 'required|string|max:14|unique:companies',
            'email' => 'required|email|unique:companies',
            'password' => 'required|string|min:8',
            'company_sector' => 'nullable|string|max:255',
            'about_company' => 'nullable|string|max:255',
        ]);

        $arrayRequest['password'] = Hash::make($arrayRequest['password']);

        $company = Company::create($arrayRequest);

        return response()->json([
            'message' => 'Empresa criada com sucesso!',
            'company' => $company,
        ], 201);
    }

    public function loginCompany(Request $request)
    {
        $credentials = $request->only('email', 'password');
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
}
