<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name_candidate' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:candidates,email',
            'password' => 'required|string|min:6|confirmed',
            'cpf' => 'required|string|unique:candidates,cpf|max:14',
            'gender' => 'nullable|string|in:masculino,feminino,nao-binario,outro',
            'birthdate' => 'nullable|date',
            'phone' => 'nullable|string|min:11|max:15|unique:candidates,phone',
            'cep' => 'nullable|string|min:8|max:9',
            'address' => 'nullable|string|min:3|max:255',
            'state' => 'nullable|string|min:2|max:255',
            'city' => 'nullable|string|min:3|max:255',
            'about_candidate' => 'nullable|string|min:3|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'soft_skills' => 'nullable|json',
            'hard_skills' => 'nullable|json',

            'language' => 'nullable|string',
            'level' => 'nullable|in:beginner,intermediate,advanced,fluent',

            'formation' => 'nullable|in:graduação,pos-graduação,mestrado,doutorado',
            'institution' => 'nullable|string',
            'experience' => 'nullable|string',
            'degree' => 'nullable|in:tecnologo,licenciatura,bacharelado',
            'status' => 'nullable|in:completo,em andamento,incompleto',
            'course' => 'nullable|string',
            'start_date_course' => 'nullable|date',
            'end_date_course' => 'nullable|date',

            'certificate_type' => 'nullable|in:conquista,certificado',
            'certificate_title' => 'nullable|string',
            'certificate_description' => 'nullable|string',
            'certificate_institution' => 'nullable|string',

            'company' => 'nullable|string',
            'position' => 'nullable|string',
            'is_currently_working' => 'nullable|boolean',
            'start_date_work' => 'nullable|date',
            'end_date_work' => 'nullable|date',
            'description_ativities' => 'nullable|string',
        ];

        $validatedData = $request->validate($rules);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('candidates/photos', $filename, 'public');
            $validatedData['photo'] = $filePath;
        }

        $validatedData['password'] = Hash::make($validatedData['password']);

        $candidate = Candidate::create($validatedData);

        return response()->json([
            'message' => 'Candidato registrado com sucesso!',
            'candidate' => $candidate,
        ], 201);
    }

    public function loginCandidate(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $candidate = Candidate::where('email', $validatedData['email'])->first();

        if (!$candidate || !Hash::check($validatedData['password'], $candidate->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas.',
            ], 401);
        }

        $token = $candidate->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso!',
            'token' => $token,
            'token_type' => 'Bearer',
            'candidate_id' => $candidate->id,
        ], 200);
    }

    public function logout()
    {
        $user = Auth::guard('candidate')->user();

        if ($user) {
            $user->tokens()->delete();
            return response()->json(['message' => 'Logout realizado com sucesso!']);
        }

        return response()->json(['message' => 'Usuário não autenticado.'], 401);
    }

    public function show($id)
    {
        $candidate = Candidate::find($id);

        if (!$candidate) {
            return response()->json(['message' => 'Candidato não encontrado'], 404);
        }

        return response()->json([
            'message' => 'Candidato encontrado com sucesso!',
            'candidate' => $candidate,
        ], 200);
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
            'phone' => 'sometimes|string|min:11|max:15|unique:candidates,phone,' . $candidate->id,
            'cep' => 'sometimes|string|min:8|max:9',
            'address' => 'sometimes|string|min:3|max:255',
            'state' => 'sometimes|string|min:2|max:255',
            'city' => 'sometimes|string|min:3|max:255',
            'about_candidate' => 'sometimes|string|min:3|max:255',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'soft_skills' => 'sometimes|json',
            'hard_skills' => 'sometimes|json',
            'language' => 'sometimes|string',
            'level' => 'sometimes|in:beginner,intermediate,advanced,fluent',
            'formation' => 'sometimes|in:graduação,pos-graduação,mestrado,doutorado',
            'institution' => 'sometimes|string',
            'experience' => 'sometimes|string',
            'degree' => 'sometimes|in:tecnologo,licenciatura,bacharelado',
            'status' => 'sometimes|in:completo,em andamento,incompleto',
            'course' => 'sometimes|string',
            'start_date_course' => 'sometimes|date',
            'end_date_course' => 'sometimes|date',
            'certificate_type' => 'sometimes|in:conquista,certificado',
            'certificate_title' => 'sometimes|string',
            'certificate_description' => 'sometimes|string',
            'certificate_institution' => 'sometimes|string',
            'company' => 'sometimes|string',
            'position' => 'sometimes|string',
            'is_currently_working' => 'sometimes|boolean',
            'start_date_work' => 'sometimes|date',
            'end_date_work' => 'sometimes|date',
            'description_ativities' => 'sometimes|string',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('candidates/photos', $filename, 'public');
            $arrayRequest['photo'] = $filePath;
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
        $user = Auth::guard('candidate')->user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        $user->delete();

        return response()->json(['message' => 'Conta excluída com sucesso!']);
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


        if (Hash::check($validatedData['password'], $candidate->password)) {
            $candidate->password = Hash::make($validatedData['new_password']);
            $candidate->save();

            return response()->json([
                'message' => 'Senha atualizada com sucesso.',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Senha atual inválida.',
            ], 400);
        }
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
}
