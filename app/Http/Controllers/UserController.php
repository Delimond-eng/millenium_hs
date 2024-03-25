<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use App\Models\HopitalEmplacement;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

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
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'agent_id'=>'required|int|exists:agents,id',
                'created_by'=>'required|int|exists:users,id',
                'pharmacie_id'=>'nullable|int|exists:pharmacies,id',
                'pharmacie_role'=>'nullable|string',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'agent_id'=> $validatedData['agent_id'],
                'pharmacie_id'=>$validatedData['pharmacie_id'],
                'pharmacie_role'=>$validatedData['pharmacie_role'],
                'created_by'=> $validatedData['created_by'],
            ]);
            return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user]);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException | \ErrorException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }


    /**
     * SEND OTP
     * @param Request $request
     * @return JsonResponse
    */
    public function sendOtp(Request $request):JsonResponse
    {
        $userEmail = $request->input('email');
        $otp = mt_rand(100000, 999999);
        $request->session()->put('otp', $otp);
        Mail::raw("Your OTP is: $otp", function ($message) use ($userEmail) {
            $message->to($userEmail)->subject('OTP Verification');
        });
        return response()->json(['message' => 'OTP sent successfully']);
    }

    /**
     * VERIFY OTP
     * @param Request $request
     * @return JsonResponse
    */
    public function verifyOtp(Request $request):JsonResponse
    {
        $userEnteredOtp = $request->input('otp');
        $storedOtp = $request->session()->get('otp');
        if ($userEnteredOtp == $storedOtp) {
            return response()->json(['message' => 'OTP verification successful']);
        } else {
            return response()->json(['message' => 'OTP verification failed'], 422);
        }
    }
}
