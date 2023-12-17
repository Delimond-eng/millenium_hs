<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use App\Models\HopitalEmplacement;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * User login
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse{
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->last_seen = now();
            $user->save();
            $token = $user->createToken('user-token')->plainTextToken;
            $role = UserRole::where('id', $user->user_role_id)->first();
            $hosto = Hopital::find($user->hopital_id);
            $emplacement = HopitalEmplacement::find($user->hopital_emplacement_id);
            $hosto['emplacement']= $emplacement;
            $user['role'] = $role;
            $user['hopital'] = $hosto;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }
        return response()->json(['errors' => 'Identifiant incorrect'], 401);
    }

    /**
     * User regester
     * @param Request $request
     * @return JsonResponse
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
