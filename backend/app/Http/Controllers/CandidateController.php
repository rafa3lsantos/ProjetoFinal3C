<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CandidateController extends Controller
{
    /**
     * Registro de um novo candidato.
     */
    public function store(Request $request)
    {
        $rules = [
            'name_candidate' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:candidates,email',
            'password' => 'required|string|min:6|confirmed',
            'cpf' => 'required|string|unique:candidates,cpf|max:14',
            'gender' => 'required|string|in:masculino,feminino,outro',
            'phone' => 'required|string|min:9|max:15',
            'about_candidate' => 'nullable|string|max:2000',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ];

        $validatedData = $request->validate($rules);

        // Upload de foto, se fornecida
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

    /**
     * Login do candidato.
     */
    public function loginCandidate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $candidate = Candidate::where('email', $request->email)->first();

        if (!$candidate || !Hash::check($request->password, $candidate->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        $token = $candidate->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'candidate' => $candidate,
        ]);
    }

    /**
     * Logout do candidato.
     */
    public function logout()
    {
        $user = Auth::guard('candidate')->user();

        if ($user) {
            $user->tokens()->delete();
            return response()->json(['message' => 'Logout realizado com sucesso!']);
        }

        return response()->json(['message' => 'Usuário não autenticado.'], 401);
    }

    /**
     * Visualizar informações do perfil do candidato autenticado.
     */
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

    /**
     * Atualizar informações do candidato.
     */
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
        ]);

        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('images', 'public');
            $arrayRequest['image'] = $imagePath;
        }

        $candidate->update($arrayRequest);

        return response()->json(['message' => 'Candidato atualizado com sucesso'], 200);
    }

    public function delete()
    {
        $user = Auth::guard('candidate')->user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        $user->delete();

        return response()->json(['message' => 'Conta excluída com sucesso!']);
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
}
