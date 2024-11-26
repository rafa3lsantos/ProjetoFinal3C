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
            'company_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_sector' => 'nullable|string|max:255',
            'about_company' => 'nullable|string|max:255',
        ]);

        $arrayRequest['password'] = Hash::make($arrayRequest['password']);

        if ($request->hasFile('company_photo')) {
            $file = $request->file('company_photo');
            $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('images', $filename, 'public');
            $arrayRequest['company_photo'] = $filePath;
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

    public function update(Request $request)
    {
        $company = Auth::user();

        if (!$company) {
            return response()->json(['message' => 'Empresa não encontrada ou não autenticada'], 401);
        }

        $arrayRequest = $request->validate([
            'company_name' => 'sometimes|string|min:3|max:255',
            'company_cnpj' => 'sometimes|string|max:14',
            'company_phone' => 'sometimes|string|min:10|max:14|unique:companies,company_phone,' . $company->id,
            'email' => 'sometimes|email|max:255',
            'password' => 'sometimes|string|min:8',
            'company_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_base64' => 'sometimes|string',
            'company_sector' => 'sometimes|string|min:3|max:255',
            'about_company' => 'sometimes|string|min:3|max:255',
        ]);

        $imageDirectory = base_path('../../../../frontend/public/company_photos');

        if ($request->hasFile('comapany_photo')) {
            try {

                $imageName = uniqid() . '.' . $request->file('comapany_photo')->getClientOriginalExtension();
                $request->file('comapany_photo')->move($imageDirectory, $imageName);

                $arrayRequest['company_photo'] = "images/$imageName";
            } catch (\Exception $e) {
                return response()->json(['message' => 'Erro ao salvar a imagem enviada.', 'error' => $e->getMessage()], 500);
            }
        }

        if ($request->filled('photo_base64')) {
            $base64Image = $request->photo_base64;

            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                try {
                    $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                    $base64Image = base64_decode($base64Image);

                    $extension = strtolower($type[1]);

                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        return response()->json(['message' => 'Formato de imagem inválido.'], 400);
                    }

                    $fileName = uniqid() . '.' . $extension;
                    $filePath = "$imageDirectory/$fileName";

                    file_put_contents($filePath, $base64Image);
                    $arrayRequest['company_photo'] = "company_photos/$fileName";
                } catch (\Exception $e) {
                    return response()->json(['message' => 'Erro ao processar imagem Base64.', 'error' => $e->getMessage()], 500);
                }
            } else {
                return response()->json(['message' => 'Imagem em Base64 inválida.'], 400);
            }
        }

        try {
            if (isset($arrayRequest['password'])) {
                $arrayRequest['password'] = Hash::make($arrayRequest['password']);
            }

            $company->update($arrayRequest);
            return response()->json(['message' => 'Empresa atualizada com sucesso', 'data' => $arrayRequest], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar as informações da empresa.', 'error' => $e->getMessage()], 500);
        }
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

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $path = $image->store('profile_images', 'public');

            $company = Company::find(auth()->id());
            $company->company_photo = $path;
            $company->save();

            return response()->json(['company_photo' => Storage::url($path)], 200);
        }

        return response()->json(['message' => 'Erro ao fazer upload da imagem.'], 400);
    }


    public function getProfileImage($id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }

        if ($company->company_photo) {
            $imageUrl = asset('storage/profile_images/' . $company->company_photo);
            return response()->json(['image_url' => $imageUrl], 200);
        }

        return response()->json(['message' => 'Empresa não possui imagem de perfil'], 404);
    }
}
