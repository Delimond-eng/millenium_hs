<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use App\Models\HopitalEmplacement;
use App\Models\User;
use App\Models\UserRole;
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
                'nom' => 'required|string|unique:hopitals,hopital_nom',
                'adresse' => 'required|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'user_name'=>'required|string',
                'user_phone'=>'required|string|unique:users,phone',
                'user_email'=>'required|email|unique:users,email',
                'user_password'=>'required|string',
            ]);

            if ($request->hasFile('logo')) {
                $domain = $request->getHttpHost();
                $image = $request->file('logo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $imageName);
                $data['logo'] = 'http://'. $domain.'/uploads/' . $imageName;
            }
            $hosto = Hopital::create([
                "hopital_nom" => $data['nom'],
                "hopital_adresse"=>$data['adresse'],
                "hopital_logo" => $data['logo'] ?? null
            ]);
            if(isset($hosto)){
                $data['hopital_id']=$hosto->id;
                $emplacement = $this->createDefaultLocation($data);
                $data['hopital_emplacement_id'] = $emplacement->id;
                $hosto['emplacement']= $emplacement;
                $admin = $this->createDefaultUserAdmin($data);
                $admin['hopital'] = $hosto;
                return response()->json([
                    "status"=>"success",
                    "user"=>$admin,
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
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }

    }


    /**
     * CREATE NEW LOCATION
     * @param Request $request
    */

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
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }

    }


    /**
     * VIEW ALL LOCATIONS
    */
    public function viewAllEmplacements($hostoId):JsonResponse{
        $hosto = Hopital::find($hostoId);
        return response()->json([
            "status"=>"success",
            "emplacements"=> $hosto->emplacements ?? [],
        ]);
    }

    /**
     * Permettre de créer un emplacement par defaut pour un hopital
     * @param $data
     * @return mixed
    */
    private function createDefaultLocation($data):mixed{
        $emplacement = HopitalEmplacement::create([
            "hopital_emplacement_libelle" => 'Siège social',
            "hopital_emplacement_adresse"=>$data['adresse'],
            "hopital_id"=> $data['hopital_id']
        ]);
        return $emplacement;
    }

    /**
     * Créer un utilisateur par défaut
     * @param $data
     * @return  mixed
    */
    private function createDefaultUserAdmin($data) : mixed{
        $admin = User::create([
            'name' => $data['user_name'],
            'email' => $data['user_email'],
            'phone' => $data['user_phone'],
            'password' => bcrypt($data['user_password']),
            'hopital_id'=> $data['hopital_id'],
            'hopital_emplacement_id'=>$data['hopital_emplacement_id'],
            'user_role_id'=> 1,
            'agent_id'=> 0,
        ]);
        $role = UserRole::where('id', 1)->first();
        $admin['role'] = $role;
        return $admin;
    }
}
