<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use App\Models\HopitalEmplacement;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HospitalController extends Controller
{
    /**
     * Hospital create statment
     * @return JsonResponse
     */
    public function createHosto(Request $request):JsonResponse{
        try {
            $data = $request->validate([
                'nom' => 'required|string',
                'adresse' => 'required|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'user_name'=>'required|string',
                'user_phone'=>'required|string|unique',
                'user_email'=>'required|email|unique',
            ]);

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $imageName);
                $data['logo'] = 'uploads/' . $imageName;
            }
            $hosto = Hopital::create([
                "hopital_nom" => $data['nom'],
                "hopital_adresse"=>$data['adresse'],
                "hopital_logo" => $data['logo']
            ]);

            if(isset($hosto)){
                $admin = User::create([
                    'name' => $data['user_name'],
                    'email' => $data['user_email'],
                    'phone' => $data['user_phone'],
                    'password' => bcrypt($data['user_password']),
                    'user_role_id'=> 1,
                    'agent_id'=> 0,
                ]);
                return response()->json([
                    "status"=>"success",
                    "user"=>$admin,
                    "hopital"=>$hosto
                ]);
            }
            else{
                return response()->json([
                    "errors"=>"Echec de la création de l'hôpital !"
                ]);
            }
        }
        catch (ValidationException $e){
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
    }

    public function createEmplacement(Request $request):JsonResponse{
        try {
            $data = $request->validate([
                "emplacement_libelle"=>'required|string',
                "emplacement_adresse"=>'required|string',
                "hopital_id"=>'required|int|exists:hopitals,id',
            ]);
            $emplacement = HopitalEmplacement::create([
                "hopital_emplacement_libelle"=>$data['emplacement_libelle'],
                "hopital_emplacement_adresse"=>$data['emplacement_adresse'],
                "hopital_id"=>$data["hopital_id"]
            ]);
            if (isset($emplacement)){
                return response()->json([
                    "status"=>"success",
                    "emplacement"=>$emplacement
                ]);
            }
            else{
                return response()->json([
                    "errors"=>"Echec de la création de l'hôpital !"
                ]);
            }
        }catch (ValidationException $e){
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
    }
}
