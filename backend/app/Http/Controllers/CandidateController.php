<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;

class CandidateController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'name_candidate' => 'required|string|min:3|max:255',
            'cpf' => 'required|string|min:11|max:14|unique:candidates',
            'birthdate' => 'nullable|date',
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
            'phone' => 'sometimes|string|min:11|max:14|unique:candidates,phone,' . $candidate->id,
            'cep' => 'sometimes|string|min:8|max:9',
            'address' => 'sometimes|string|min:3|max:255',
            'state' => 'sometimes|string|min:2|max:255',
            'city' => 'sometimes|string|min:3|max:255',
            'about_candidate' => 'sometimes|string|min:3|max:255',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('images', 'public');
            $arrayRequest['image'] = $imagePath;
        }

        $candidate->update($arrayRequest);

        return response()->json(['message' => 'Candidato atualizado com sucesso'], 200);
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
            return response()->json(['message' => 'Candidato não encontrada'], 404);
        }

        return response()->json([
            'message' => 'candidato encontrado com sucesso!',
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
        ]);

        if ($validatedData['email'] !== $candidate->email) {
            return response()->json(['message' => 'O email atual está incorreto.'], 403);
        }

        $candidate->update(['email' => $validatedData['new_email']]);

        return response()->json(['message' => 'Seu email foi atualizado com sucesso!'], 200);
    }
}
