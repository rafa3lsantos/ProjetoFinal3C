<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_cnpj' => 'required|string|max:14|unique:companies',
            'company_phone' => 'nullable|string|max:255',
            'email' => 'required|email|unique:companies',
            'password' => 'required|string|min:8',
            'company_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'company_sector' => 'nullable|string|max:255',
            'about_company' => 'nullable|string|max:255',
        ]);

        $arrayRequest['password'] = Hash::make($arrayRequest['password']);

        if ($request->hasFile('company_photo')) {
            $path = $request->file('company_photo')->store('public/company_photos');
            $arrayRequest['company_photo'] = $path;
        }

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
                'message' => 'Usuário autenticado com sucesso!',
                'token' => $token,
                'company_id' => $company->id,
            ]);
        }

        return response()->json(['message' => 'Falha na autenticação do usuário'], 401);
    }

    public function update(Request $request, $id)
    {
        $arrayRequest = $request->validate([
            'company_name' => 'sometimes|string|max:255',
            'company_cnpj' => 'sometimes|string|max:14',
            'company_phone' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'password' => 'sometimes|string|min:8',
            'company_photo' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:2048', // Validação para imagens
            'company_sector' => 'sometimes|string|max:255',
            'about_company' => 'sometimes|string|max:255',
        ]);

        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }

        if (isset($arrayRequest['password'])) {
            $arrayRequest['password'] = Hash::make($arrayRequest['password']);
        }

        if ($request->hasFile('company_photo')) {
            if ($company->company_photo && Storage::exists($company->company_photo)) {
                Storage::delete($company->company_photo);
            }

            $path = $request->file('company_photo')->store('public/company_photos');
            $arrayRequest['company_photo'] = $path;
        }

        $company->update($arrayRequest);

        return response()->json([
            'message' => 'Empresa atualizada com sucesso!',
            'company' => $company,
        ], 200);
    }

    public function show($id)
    {
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
