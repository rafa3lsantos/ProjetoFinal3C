<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;


class CandidateController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'name_candidate' => 'required|string|min:3|max:255',
            'cpf' => 'required|string|min:11|max:14|unique:candidates',
            'gender' => 'nullable|string|in:masculino,feminino,nao-binario,outro',
            'phone' => 'nullable|string|min:11|max:14|unique:candidates',
            'email' => 'required|string|min:3|max:255|unique:candidates',
            'password' => 'required|string|min:6|max:255|confirmed',
            'password_confirmation' => 'required|string|min:6|max:255',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHis') . '_' . $file->getClientOriginalName();

            $filePath = $file->storeAs('images', $filename, 'public');

            $arrayRequest['photo'] = $filePath;
        }


        $arrayRequest['password'] = Hash::make($arrayRequest['password']);
        unset($arrayRequest['password_confirmation']);

        $candidate = Candidate::create($arrayRequest);

        return response()->json([
            'message' => 'Cadastrado com sucesso!',
            'candidate' => $candidate,
        ], 201);
    }

    public function loginCandidate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);


        if (Auth::guard('candidate')->attempt($credentials)) {
            $candidate = Auth::guard('candidate')->user();
            $token = $candidate->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Candidato autenticado com sucesso!',
                'token' => $token,
                'candidate_id' => $candidate->id,
                'curriculum_id' => $candidate->curriculum_id,
            ], 200);
        }

        return response()->json(['message' => 'Falha na autenticação do candidato', 'error' => 'Credenciais inválidas'], 401);
    }

    public function updateCandidate(Request $request)
    {
        $candidate = Auth::user();

        if (!$candidate) {
            return response()->json(['message' => 'Candidato não encontrado ou não autenticado'], 401);
        }

        $arrayRequest = $request->validate([
            'name_candidate' => 'sometimes|string|min:3|max:255',
            'gender' => 'sometimes|string|in:masculino,feminino,nao-binario,outro',
            'birthdate' => 'sometimes|date',
            'phone' => 'sometimes|string|min:11|max:14|unique:candidates,phone,' . $candidate->id,
            'cep' => 'sometimes|string|min:8|max:9',
            'address' => 'sometimes|string|min:3|max:255',
            'state' => 'sometimes|string|min:2|max:255',
            'city' => 'sometimes|string|min:3|max:255',
            'about_candidate' => 'sometimes|string|min:3|max:255',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_base64' => 'sometimes|string',
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
            $candidate->update($arrayRequest);
            return response()->json(['message' => 'Candidato atualizado com sucesso', 'data' => $arrayRequest], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar as informações do candidato.', 'error' => $e->getMessage()], 500);
        }
    }


    public function deleteCandidate(Request $request)
    {
        $candidate = Auth::user();
        if (!$candidate) {
            return response()->json(['message' => 'Candidato não encontrado ou não autenticado'], 401);
        }

        $candidate->delete();

        return response()->json(['message' => 'Candidato deletado com sucesso'], 200);
    }

    public function show($id)
    {

        $candidate = Candidate::find($id);


        if (!$candidate) {
            return response()->json(['message' => 'Candidato não encontrado'], 404);
        }

        $candidate->photo_url = Storage::url($candidate->photo);

        return response()->json([
            'message' => 'Candidato encontrado com sucesso!',
            'candidate' => $candidate,
        ], 200);
    }



    public function logoutCandidate(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!',
        ], 200);
    }

    public function index()
    {
        $candidates = Candidate::all();

        return response()->json([
            'message' => 'Listagem de candidatos realizada com sucesso!',
            'candidates' => $candidates,
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $candidate = Auth::user();

        if (!$candidate) {
            return response()->json(['message' => 'Candidato não encontrado ou não autenticado'], 401);
        }

        $validatedData = $request->validate([
            'password' => 'required|string',
            'new_password' => 'required|string|min:6|max:255|confirmed',
            'new_password_confirmation' => 'required|string|min:6|max:255',
        ]);


        if (!Hash::check($validatedData['password'], $candidate->password)) {
            return response()->json(['message' => 'A senha atual está incorreta.'], 403);
        }


        $candidate->update(['password' => bcrypt($validatedData['new_password'])]);

        return response()->json(['message' => 'Senha atualizada com sucesso!'], 200);
    }


    public function updateEmail(Request $request)
    {
        $candidate = Auth::user();

        if (!$candidate) {
            return response()->json(['message' => 'Candidato não encontrado ou não autenticado'], 401);
        }

        $validatedData = $request->validate([
            'email' => 'required|string|min:3|max:255',
            'new_email' => 'required|string|min:6|max:255|confirmed|unique:candidates,email',
            'new_email_confirmation' => 'required|string|min:6|max:255',
        ]);

        if ($validatedData['email'] !== $candidate->email) {
            return response()->json(['message' => 'O email atual está incorreto.'], 403);
        }

        $candidate->update(['email' => $validatedData['new_email']]);

        return response()->json(['message' => 'Seu email foi atualizado com sucesso!'], 200);
    }

    public function uploadProfileImage(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');

            $path = $image->store('profile_images', 'public');

            $candidate = Candidate::find(auth()->id());

            $candidate->photo = $path;
            $candidate->save();
            return response()->json(['photo' => Storage::url($path)], 200);
        }


        return response()->json(['message' => 'Erro ao fazer upload da imagem.'], 400);
    }


    public function getProfileImage($id)
    {
        $candidate = Candidate::find($id);
        if (!$candidate) {
            return response()->json(['message' => 'Candidato não encontrado'], 404);
        }

        if ($candidate->photo) {
            $imageUrl = asset('storage/profile_images/' . $candidate->photo);
            return response()->json(['image_url' => $imageUrl], 200);
        }

        return response()->json(['message' => 'Candidato não possui imagem de perfil'], 404);
    }
}
