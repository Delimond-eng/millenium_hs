<?php

namespace App\Http\Controllers;

use App\Models\FacturePaiement;
use App\Models\Hopital;
use App\Models\HopitalEmplacement;
use App\Models\TransfertPatient;
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
                "created_by"=>"required|int"
            ]);
            $emplacement = HopitalEmplacement::create([
                "hopital_emplacement_libelle"=>$data['emplacement_libelle'],
                "hopital_emplacement_adresse"=>$data['emplacement_adresse'],
                "hopital_id"=>$data["hopital_id"],
                "created_by"=>$data["created_by"]
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
            "hopital_id"=> $data['hopital_id'],
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
            'menus'=> "Tableau de bord,Configurations,Agents,Services,Laboratoires,Partenaires",
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

    /**
     * Effectuer un transfert d'un patient dans un X hopital
     * @param Request $request
     * @return JsonResponse
    */
    public function makePatientTransfert(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                "transfert_hopital"=>'required|string',
                "transfert_motif"=>'required|string',
                "transfert_date"=>'required|date',
                "created_by"=>"required|int|exists:users,id",
                "patient_id"=>"required|int|exists:patients,id",
                "agent_id"=>"required|int|exists:agents,id",
                "hopital_emplacement_id"=>"required|int|exists:hopital_emplacements,id",
            ]);
            $result = TransfertPatient::create($data);
            if (isset($result)){
                return response()->json([
                    "status"=>"success",
                    "result"=>$result
                ]);
            }
            else{
                return response()->json([
                    "errors"=>"Echec du transfert !"
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
     * Voir tous les transfert par emplacements
     * @return JsonResponse
    */
    public function allTransfertsByEmplament(int $emplacementId):JsonResponse
    {
        $transferts = TransfertPatient::with('patient')
            ->with('emplacement')
            ->with('agent')
            ->with('user')
            ->where('hopital_emplacement_id', $emplacementId)
        ->get();
        return response()->json([
            "status"=>"success",
            "transferts"=>$transferts
        ]);
    }



    /**
     * Effectuer un transfert d'un patient dans un X hopital
     * @param Request $request
     * @return JsonResponse
     */
    public function makePayFacture(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                "paiement_montant"=>'required|numeric',
                "paiement_montant_devise"=>'required|string',
                "created_by"=>"required|int|exists:users,id",
                "patient_id"=>"required|int|exists:patients,id",
                "facturation_id"=>"required|int|exists:facturation_configs,id",
                "hopital_emplacement_id"=>"required|int|exists:hopital_emplacements,id",
            ]);
            $result = FacturePaiement::create($data);
            if (isset($result)){
                return response()->json([
                    "status"=>"success",
                    "result"=>$result
                ]);
            }
            else{
                return response()->json([
                    "errors"=>"Echec de la facturation !"
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
     * Voir tous les paiements par emplacements
     * @return JsonResponse
     */
    public function allPaiementsByEmplament(int $emplacementId):JsonResponse
    {
        $paiements = FacturePaiement::with('patient')
            ->with('emplacement')
            ->with('user.agent')
            ->with('facturation')
            ->where('hopital_emplacement_id', $emplacementId)
            ->get();
        return response()->json([
            "status"=>"success",
            "paiements"=>$paiements
        ]);
    }

}
