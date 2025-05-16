<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $validate = $request->validate([
            'login' => ['required', 'unique:users,login'],
            'password' => ['required'],
            'email' => ['required', 'email'],
            'last_name' => ['required'],
            'first_name' => ['required'],
            'role_id' => ['required'],
        ]);

        $validate['password'] = bcrypt($validate['password']);
        

        $user = User::create($validate);

        return response()->json([
            'message' => 'Utilisateur enregistré avec succès',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Login ou mot de passe incorrect',
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Authentification réussie',
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->noContent();
    }
}
