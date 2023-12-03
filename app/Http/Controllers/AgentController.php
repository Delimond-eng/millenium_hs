<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use App\Models\ConsultationDetails;
use App\Models\Consultations;
use App\Models\Prescriptions;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isEmpty;

class AgentController extends Controller
{

    /**
     * all agents
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(): JsonResponse
    {
        $agents = Agents::with('fonction')
                ->with('service')
                ->with('grade')
                ->get();
        return response()->json([
            "status"=>"success",
            "agents"=>$agents
        ]);
    }

    /**
     * create new agent
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try
        {
             /** @var mixed check validate datas */
             $data = $request->validate([
                'matricule' => 'required|string|unique:agents,agent_matricule',
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'sexe' => 'required|string|max:1',
                'telephone' => 'required|string|min:10|unique:agents,agent_telephone',
                'adresse' => 'required|string',
                'datenais' => 'required|date|date_format:Y-m-d',
                'fonction_id'=>'required|int|exists:fonctions,id',
                'service_id'=>'required|int|exists:services,id',
                'grade_id'=>'required|int|exists:grades,id',
                'created_by'=> 'required|int|exists:users,id',
            ]);

            /** @var mixed create agent */
            $agent = Agents::create([
                'agent_matricule' => $data['matricule'],
                'agent_nom' => $data['nom'],
                'agent_prenom' => $data['prenom'],
                'agent_sexe' => $data['sexe'],
                'agent_telephone' => $data['telephone'],
                'agent_adresse' => $data['adresse'],
                'agent_datenais' => $data['datenais'],
                'agent_specialite' => $request->specialite,
                'fonction_id'=>$data['fonction_id'],
                'grade_id'=>$data['grade_id'],
                'service_id'=>$data['service_id'],
                'created_by'=>$data['created_by'],
            ]);

            /** @var mixed check if user account permission isAllowed */
            $userDatas= $request->user_data;
            if(isset($agent) && (isset($userDatas) && !empty($userDatas))){
                $user = User::create([
                    "name"=>$data['prenom'],
                    "email"=>$userDatas["email"],
                    "password"=>bcrypt($userDatas["password"]),
                    "agent_id"=>$agent->id,
                    "user_role_id"=>$userDatas["role_id"]
                ]);
                $agent['user'] = $user;
            }
            return response()->json([
                "status"=>"success",
                "agent"=>$agent
            ]);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }


    }

    /**
     * Assign un agent a un compte utilisateur
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     */
    public function assignAccount(Request $request)
    {
        try{
            $data = $request->validate([
                'agent_id'=>'required|int|exists:agents,id',
                'user_id'=>'required|int|exists:users,id',
                'hopital_id'=>'required|int|exists:hopitals,id',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
            ]);
             // Recherche de l'utilisateur à mettre à jour par son ID
            $user = User::findOrFail($data['user_id']);
            // Mise à jour des attributs de l'utilisateur avec les données validées
            $user->update([
                'agent_id'=> $data['agent_id'],
            ]);
            return response()->json(['user' => $user]);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ], 422);
        }
    }


    /**
     * VOIR LA LISTE DE TOUS LES PATIENTS ASSIGNES A UN MEDECIN
    */
    public function showPendingPatient($agentId){
        //$agent = Agents::find($agentId);
        $agent = Agents::find($agentId);
        if(isset($agent)){
            $patients = $agent->assignPatients;
            return response()->json([
                "status"=>"success",
                "patients"=>$patients
            ]);
        }
        else{
            return response()->json([
                "status"=>"failed",
                "message"=>"agent non reconnu"
            ], 401);
        }
    }



    /**
     * CREATION D'UNE NOUVELLE CONSULTATIONS
    */
    public function  createConsultations(Request $request): JsonResponse{
        try
        {
            $details = $request->consult_details;
            /** @var mixed check validate datas */
            $data = $request->validate([
                'libelle' => 'required|string',
                'diagnostic' => 'required|string|min:10',
                'patient_id'=>'required|int|exists:patients,id',
                'agent_id'=>'required|int|exists:agents,id',
            ]);
            $consultation = Consultations::create([
                "consult_libelle" => $data['libelle'],
                "consult_diagnostic" => $data['diagnostic'],
                "patient_id" => $data['patient_id'],
                "agent_id" => $data['agent_id']
            ]);
            if(isset($consultation)){
                if(isset($details)){
                    foreach ($details as $detail){
                        $consultationDetail = ConsultationDetails::create([
                            "consult_detail_libelle"=>$detail['detail_libelle'],
                            "consult_detail_valeur"=>$detail['detail_valeur'],
                            "consult_id"=>$consultation->id
                        ]);
                    }
                }
                return response()->json([
                    "status"=>"success",
                    "consultation"=>$consultation
                ]);
            }
            else{
                return response()->json([
                    "errors"=>"Echec de l'opération !"
                ]);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }

    }


    /**
     * CREATION PRESCRIPTION
    */
    public function addPrescriptions(Request $request): JsonResponse{
        try
        {
            $prescriptions = $request->prescriptions;
            if(isset($prescriptions)){
                foreach ($prescriptions as $data){
                    $prescription = Prescriptions::create([
                        "prescription_traitement" => $data['traitement'],
                        "prescription_posologie" => $data['posologie'],
                        "prescription_traitement_type" => $data['traitement_type'],
                        "consult_id" => $data['consult_id']
                    ]);
                }
                return response()->json([
                    "status"=>"success",
                    "message"=>"Prescriptions ajoutées avec succès !"
                ]);
            }
            else{
                return response()->json([
                    "errors"=>"Prescriptions médicales requises !"
                ]);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
    }


    public function viewAllConsultations():JsonResponse
    {
        $consultations = Consultations::with('agent')
                ->with('patient')
                ->with('prescriptions')
                ->orderByDesc('id')
                ->get();
        return response()->json([
            "status"=>"success",
            "consultations"=>$consultations
        ]);
    }

}
