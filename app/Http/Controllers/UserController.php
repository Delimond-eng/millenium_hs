<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * User login
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('user-token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }
        return response()->json(['errors' => 'Identifiant incorrect'], 401);
    }

    /**
     * User regester
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'agent_id'=> 0, // Assurez-vous de hasher le mot de passe
        ]);
        // Réponse JSON
        return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user]);
    }
}
