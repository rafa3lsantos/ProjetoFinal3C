<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecruiterController extends Controller
{
    public function store(Request $request)
    {
        $authenticatedCompany = Auth::user();

        if (!$authenticatedCompany) {
            return response()->json([
                'message' => 'Ação não autorizada. Faça login como empresa.',
            ], 403);
        }

        $arrayRequest = $request->validate([
            'recruiter_name' => 'required|string|max:255',
            'recruiter_cpf' => 'required|string|max:14|unique:recruiters',
            'recruiter_gender' => 'in:male,female,non-binary,other,prefer not to say',
            'recruiter_phone' => 'required|string|max:20',
            'recruiter_birthdate' => 'sometimes|date',
            'email' => 'required|email|unique:recruiters',
            'password' => 'required|string|min:8',
            'recruiter_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $arrayRequest['password'] = Hash::make($arrayRequest['password']);
        $arrayRequest['company_id'] = $authenticatedCompany->id;

        if ($request->hasFile('recruiter_photo')) {
            $path = $request->file('recruiter_photo')->store('photos', 'public');
            $arrayRequest['recruiter_photo'] = $path;
        }

        $recruiter = Recruiter::create($arrayRequest);

        return response()->json([
            'message' => 'Recrutador criado com sucesso!',
            'recruiter' => $recruiter,
            'company_id' => $recruiter->company_id,
            'company_name' => $recruiter->company->company_name,
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
                'company_id' => $recruiter->company_id,
                'company_name' => $recruiter->company->company_name,
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

        if (!$recruiter) {
            return response()->json([
                'message' => 'Recrutador não encontrado.',
            ], 404);
        }

        $arrayRequest = $request->validate([
            'recruiter_name' => 'sometimes|string|max:255',
            'recruiter_cpf' => 'sometimes|string|max:14',
            'recruiter_gender' => 'sometimes|string|in:male,female,non-binary,other,prefer not to say',
            'recruiter_phone' => 'sometimes|string|max:20',
            'recruiter_birthdate' => 'sometimes|date',
            'email' => 'sometimes|email',
            'password' => 'sometimes|string|min:8',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        $imageDirectory = base_path('../../../../frontend/public/images');

        if ($request->hasFile('photo')) {
            try {

                $imageName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
                $request->file('photo')->move($imageDirectory, $imageName);

                $arrayRequest['photo'] = "images/$imageName";
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
                    $arrayRequest['photo'] = "images/$fileName";
                } catch (\Exception $e) {
                    return response()->json(['message' => 'Erro ao processar imagem Base64.', 'error' => $e->getMessage()], 500);
                }
            } else {
                return response()->json(['message' => 'Imagem em Base64 inválida.'], 400);
            }
        }

        try {
            $recruiter->update($arrayRequest);
            return response()->json(['message' => 'Recrutador atualizado com sucesso', 'data' => $arrayRequest], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar as informações do candidato.', 'error' => $e->getMessage()], 500);
        }
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

    public function uploadProfileImage(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $path = $image->store('profile_images', 'public');

            $recruiter = Recruiter::find(auth()->id());
            $recruiter->recruiter_photo = $path;
            $recruiter->save();

            return response()->json(['recruiter_photo' => Storage::url($path)], 200);
        }

        return response()->json(['message' => 'Erro ao fazer upload da imagem.'], 400);
    }


    public function getProfileImage($id)
    {
        $recruiter = Recruiter::find($id);
        if (!$recruiter) {
            return response()->json(['message' => 'Recrutador não encontrado'], 404);
        }

        if ($recruiter->recruiter_photo) {
            $imageUrl = asset('storage/profile_images/' . $recruiter->recruiter_photo);
            return response()->json(['image_url' => $imageUrl], 200);
        }

        return response()->json(['message' => 'Recrutador não possui imagem de perfil'], 404);
    }


}
