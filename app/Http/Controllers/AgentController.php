<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use App\Models\ConsultationDetails;
use App\Models\ConsultationExamens;
use App\Models\Consultations;
use App\Models\ConsultationSymptomes;
use App\Models\MedicalSchedule;
use App\Models\Patients;
use App\Models\PatientSignesVitaux;
use App\Models\PatientSuivi;
use App\Models\PatientTraitement;
use App\Models\PremierSoin;
use App\Models\PremierSoinTraitement;
use App\Models\Prescriptions;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isEmpty;

class AgentController extends Controller
{

    /**
     * all agents
     * @param int $hostoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(int $hostoId): JsonResponse
    {
        $agents = Agents::with('fonction')
                ->with('service')
                ->with('emplacement')
                ->with('grade')->where('hopital_id', $hostoId)
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
    public function createAgent(Request $request)
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
                'adresse' => 'nullable|string',
                'datenais' => 'nullable|date|date_format:Y-m-d',
                'fonction_id'=>'nullable|int|exists:fonctions,id',
                'service_id'=>'nullable|int|exists:services,id',
                'grade_id'=>'nullable|int|exists:grades,id',
                'hopital_id'=> 'required|int|exists:hopitals,id',
                'emplacement_id'=> 'required|int|exists:hopital_emplacements,id',
                'created_by'=> 'required|int',
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
                'hopital_id'=>$data['hopital_id'],
                'hopital_emplacement_id'=>$data['emplacement_id'],
                'created_by'=>$data['created_by'],
            ]);

            /** @var mixed check if user account permission isAllowed */
            $userDatas= $request->user_data;
            if(isset($agent) && (isset($userDatas) && !empty($userDatas))){
                $user = User::create([
                    "name"=>$data['prenom'],
                    "email"=>$userDatas["email"],
                    "password"=>bcrypt($userDatas["password"]),
                    "menus"=>$userDatas['menus'],
                    "phone"=>$data['telephone'],
                    "agent_id"=>$agent->id,
                    "user_role_id"=>$userDatas["role_id"],
                    'hopital_id'=>$data['hopital_id'],
                    'hopital_emplacement_id'=>$data['emplacement_id'],
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
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ], 422);
        }
    }


    /**
     * Permet au medecin de sauvegarder les données des premiers soins administrés à un patient
     * @param Request $request
     * @author Gaston Delimond
     * @DateTime 16/01/2024 13:50
     * @return JsonResponse
    */
    public function administrerPremierSoins(Request $request):JsonResponse
    {
        try {
            $datas = $request->validate([
                'premier_soin_date_heure'=>'required|date_format:Y-m-d H:i',
                'premier_soin_motif'=>'required|string',
                'premier_soin_obs'=>'nullable|string',
                'patient_id'=>'required|int|exists:patients,id',
                'agent_id'=>'required|int|exists:agents,id',
                'created_by'=>'required|int|exists:users,id',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'traitements'=>'required|array'
            ]);

            $result = PremierSoin::create($datas);
            if(isset($result)){
                $traitements = $datas['traitements'];
                foreach ($traitements as $data){
                    PremierSoinTraitement::create([
                        'ps_traitement_libelle'=>$data['ps_traitement_libelle'],
                        'ps_traitement_type'=>$data['ps_traitement_type'],
                        'ps_traitement_dosage'=>$data['ps_traitement_dosage'],
                        'ps_traitement_unite'=>$data['ps_traitement_unite'],
                        'premier_soin_id'=>$result->id,
                    ]);
                }
                return response()->json([
                    "status"=>"success",
                    "result"=>$result
                ]);
            }
            else{
                return response()->json(['errors' => 'Echec de traitement de la requête !' ]);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }


    /**
     * Renvoie une liste des premiers soins
     * @return JsonResponse
    */
    public function allPremierSoins(int $locationId):JsonResponse
    {
        $results = PremierSoin::with('traitements')
            ->with('emplacement')
            ->with('agent')
            ->with('patient')
            ->where('hopital_emplacement_id', $locationId)
            ->get();
        return response()->json([
            "status"=>"success",
            "results"=>$results
        ]);
    }



    /**
     * CREATION D'UNE NOUVELLE CONSULTATIONS
     * @param Request $request
     * @author Gaston delimond
     * @return JsonResponse
    */
    public function  createConsultations(Request $request): JsonResponse{
        try
        {
            /** @var mixed check validate datas */
            $data = $request->validate([
                'libelle' => 'required|string',
                'diagnostic' => 'required|string|min:10',
                'patient_id'=>'required|int|exists:patients,id',
                'agent_id'=>'required|int|exists:agents,id',
                'hopital_id'=>'required|int|exists:hopitals,id',
                'emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'created_by'=>'required|int|exists:users,id',
                "consult_details"=>"nullable|array",
                "consult_symptomes"=>"required|array",
                "consult_id"=>"nullable|int"
            ]);

            $consultation = Consultations::updateOrCreate(
                ['id'=>$data['consult_id'] ?? null],
                [
                    "consult_libelle" => $data['libelle'],
                    "consult_diagnostic" => $data['diagnostic'],
                    "patient_id" => $data['patient_id'],
                    "agent_id" => $data['agent_id'],
                    "hopital_id" => $data['hopital_id'],
                    "hopital_emplacement_id" => $data['emplacement_id'],
                    'created_by'=>$data['created_by'],
                ]
            );
            if(isset($consultation)){
                //update patient status
                $patient = Patients::find($data['patient_id']);
                $patient->patient_traitement_status = 'sous traitement';
                $patient->save();

                //update signes vitaux
                $latestSigne = PatientSignesVitaux::where('patient_id', $data['patient_id'])
                    ->orderByDesc('id')
                    ->first();
                if(isset($latestSigne)){
                    $latestSigne
                        ->update(['consult_id'=>$consultation->id]);
                }
                //Details
                $details = $data['consult_details'];
                $data['consult_id'] = $consultation->id;
                if(isset($details)){
                    foreach ($details as $detail){
                        $consultationDetail = ConsultationDetails::updateOrCreate(
                            ["id"=>$detail['id'] ?? null],
                            [
                                "consult_detail_libelle"=>$detail['detail_libelle'],
                                "consult_detail_valeur"=>$detail['detail_valeur'],
                                "consult_id"=>$data['consult_id'],
                                "hopital_id" => $data['hopital_id'],
                                "hopital_emplacement_id" => $data['emplacement_id'],
                                "created_by"=>$data['created_by'],
                            ]
                        );
                    }
                }
                /**
                 * Créer les symptômes recensés
                 */
                $symptomes = $data['consult_symptomes'];
                if(isset($symptomes)){
                    foreach ($symptomes as $symptome){
                        $consultSymptome = ConsultationSymptomes::updateOrCreate(
                            ["id"=>$symptome['id'] ?? null],
                            [
                                'consult_symptome_libelle'=>$symptome['libelle'],
                                "consult_id"=>$data['consult_id'],
                                "created_by"=>$data['created_by']
                            ]
                        );
                    }
                }
                return response()->json([
                    "status"=>"success",
                    "consultation"=>$consultation
                ]);
            }
            else{
                return response()->json(['errors' => 'Echec de traitement de la requête !']);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
        catch (\ErrorException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }

    }


    /**
     * Ajoute les prescriptions pour une consultations
     * @param Request $request,
     * @author Gaston delimond
     * @return JsonResponse
    */
    public function addPrescriptions(Request $request): JsonResponse{
        try
        {
            $validateDatas = $request->validate([
                'prescriptions'=>'required|array'
            ]);
            $code = $this->getRandomCode(length: 5);
            $prescriptions = $request->prescriptions;
            if(isset($prescriptions)){
                foreach ($prescriptions as $data){
                    $prescription = Prescriptions::create([
                        "prescription_code" => $code,
                        "prescription_traitement_duree" => $data['duree'],
                        "prescription_traitement_duree_unite" => $data['duree_unite'],
                        "prescription_traitement_dosage" => $data['dosage'],
                        "prescription_traitement_dosage_unite" => $data['dosage_unite'],
                        "prescription_traitement_freq" => $data['frequence'],
                        "prescription_traitement_freq_unite" => $data['frequence_unite'],
                        "prescription_traitement_qte" => $data['qte'],
                        "prescription_traitement_qte_unite" => $data['dosage_unite'],
                        "produit_id" => $data['produit_id'],
                        "consult_id" => $data['consult_id'],
                        'hopital_emplacement_id' => $data['emplacement_id'],
                        'created_by'=>$data['created_by']
                    ]);
                }
                $prescription = Prescriptions::with('produit')
                    ->with('user')
                    ->where('prescription_code', $code)
                    ->get();
                //Trouver la consultation pour mettre le patient sous traitement
                $consultationId = $prescriptions[0]['consult_id'];
                $consultation = Consultations::find($consultationId);
                //mettre à jour le status du patient
                $patient = $this->updatePatientTraitementStatus($consultation->patient_id);
                return response()->json([
                    "status"=>"success",
                    "result"=>$prescription
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
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ], 422);
        }
    }

    /**
     * Ajoute une prescription des examens à une consultation
     * @param Request $request
     * @author Gaston delimond
     * @return JsonResponse
    */
    public function addExamens(Request $request): JsonResponse{
        try
        {
            $data = $request->validate([
                'examens'=>'required|array'
            ]);
            $code = $this->getRandomCode(length: 6);
            $examens = $request->examens;
            if(isset($examens)){
                foreach ($examens as $data){
                    $prescription = ConsultationExamens::create([
                        "code"=> $code,
                        "examen_id" => $data['examen_id'],
                        "agent_id" => $data['agent_id'],
                        "consult_id" => $data['consult_id'],
                        "patient_id" => $data['patient_id'],
                        'hopital_emplacement_id' => $data['emplacement_id'],
                        'hopital_id' => $data['hopital_id'],
                        'created_by'=>$data['created_by']
                    ]);
                }
                 $prescription = ConsultationExamens::with('examen')
                    ->with('agent')
                    ->where('code', $code)
                    ->get();
                return response()->json([
                    "status"=>"success",
                    "result"=> $prescription,
                    "message"=>"Prescription examens effectuées avec succès !"
                ]);
            }
            else{
                return response()->json([
                    "errors"=>"Examens médicales requises !"
                ]);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ], 422);
        }
    }

    /**
     * Valide une prescription des examens en attente de validation
     * @param Request $request
     * @return JsonResponse
     */
    public function validateExamens($consultId):JsonResponse
    {
        $examen = ConsultationExamens::where('consult_id', $consultId)->get();
        foreach ($examen as  $e){
           if($e->consult_examen_status == 'en attente'){
               $e->consult_examen_status = "validé";
           }
           else{
               $e->consult_examen_status = "en attente";
           }
           $e->save();
        }
        return response()->json([
            "status"=>"success",
            "result"=>$examen
        ]);
    }


    /**
     * update patient traitement status
     * @param int $patientID
    */
    public function updatePatientTraitementStatus(int $patientID)
    {
        $patient = Patients::find($patientID);
        if (isset($patientID)){
            $patient->patient_traitement_status = "sous traitement";
            $patient->save();
            return $patient;
        }
        return null;
    }


    /**
     * Valide une prescription des examens en attente de validation
     * @param Request $request
     * @return JsonResponse
     */
    public function validatePrescriptions($consultId):JsonResponse
    {
        $examen =Prescriptions::where('consult_id', $consultId)->get();
        foreach ($examen as  $e){
            if($e->prescription_status == 'actif'){
                $e->prescription_status = "validé";
            }
            else{
                $e->prescription_status = "actif";
            }
            $e->save();
        }
        return response()->json([
            "status"=>"success",
            "result"=>$examen
        ]);
    }


    /**
     * Affiche les details pour un examen
     * @return JsonResponse
    */
    public function showDemandExamDetails($consultId){
        $detail = ConsultationExamens::with('examen')
            ->where('consult_id', $consultId)->get();
        return response()->json([
            "status"=>"success",
            "detail"=>$detail
        ]);
    }

    /**
     * Affiche les details pour une prescriptions
     * @return JsonResponse
    */
    public function showPrescriptionDetails($consultId) :JsonResponse{
        $detail = Prescriptions::where('consult_id', $consultId)->get();
        return response()->json([
            "status"=>"success",
            "detail"=>$detail
        ]);
    }


    /**
     * Affiche la liste de toutes les consultations avec leur details
     * @return JsonResponse
    */
    public function viewAllConsultations( int $locationId):JsonResponse
    {
        $consultations = Consultations::with('agent')
                ->with('patient')
                ->with('signe')
                ->with('prescriptions.produit.type')
                ->with('antecedents')
                ->with('symptomes')
                ->with('examens.examen')
                ->orderByDesc('id')
                ->where('hopital_emplacement_id', $locationId)
                ->get();
        return response()->json([
            "status"=>"success",
            "consultations"=>$consultations
        ]);
    }

    /**
     * Voir tous les axamens pour chaque consultation
     * @param int emplacementId
     * @return JsonResponse
    */
    public function allExamens(int $emplacementId):JsonResponse
    {
        /*
         ConsultationExamens::with('emplacement')
            ->with('agent')
            ->with('consultation')
            ->with('examen')
            ->select(['consultation_examens.consult_id'])
            ->leftJoin('hopital_emplacements as emplacements', 'emplacements.id', '=', 'consultation_examens.hopital_emplacement_id')
            ->leftJoin('agents', 'agents.id', '=', 'consultation_examens.agent_id')
            ->leftJoin('consultations', 'consultations.id', '=', 'consultation_examens.consult_id')
            ->leftJoin('examen_labos as examens', 'examens.id', '=', 'consultation_examens.examen_id')
            ->where('consultation_examens.hopital_emplacement_id', $emplacementId)
            ->groupBy(['consultation_examens.consult_id'])
            ->get();
          */
        $examens = DB::select('
            SELECT
                MAX(c.consult_examen_create_At) as consult_examen_create_At,
                MAX(c.consult_examen_status) as consult_examen_status,
                MAX(c.patient_id) as patient_id,
                MAX(c.consult_id) as consult_id,
                MAX(c.agent_id) as agent_id,
                MAX(e.hopital_emplacement_libelle) as hopital_emplacement_libelle,
                MAX(a.agent_matricule) as agent_matricule,
                MAX(a.agent_nom) as agent_nom,
                MAX(a.agent_prenom) as agent_prenom,
                MAX(p.patient_code) as patient_code,
                MAX(p.patient_nom) as patient_nom,
                MAX(p.patient_prenom) as patient_prenom
            FROM consultation_examens AS c
            INNER JOIN consultations AS cs ON c.consult_id = cs.id
            INNER JOIN hopital_emplacements AS e ON c.hopital_emplacement_id = e.id
            INNER JOIN agents AS a ON c.agent_id = a.id
            INNER JOIN patients AS p ON c.patient_id = p.id
            WHERE c.hopital_emplacement_id = ? AND c.consult_examen_status = ?
            GROUP BY cs.id;
        ',[$emplacementId, 'en attente']);
        return response()->json([
            "status"=>"success",
            "examens"=>$examens
        ]);

    }

    /**
     * Voir toutes les prescriptions pour chaque consultation
     * @param int emplacementId
     * @return JsonResponse
     */
    public function allPendingPrescription(int $emplacementId):JsonResponse
    {
        $prescriptions = DB::select('
            SELECT
                MAX(pe.prescription_create_At) as prescription_create_At,
                MAX(pe.prescription_status) as prescription_status,
                MAX(pe.prescription_traitement) as prescription_traitement,
                MAX(pe.prescription_traitement_type) as prescription_traitement_type,
                MAX(pe.prescription_posologie) as prescription_posologie,
                MAX(pe.consult_id) as consult_id,
                MAX(e.hopital_emplacement_libelle) as hopital_emplacement_libelle,
                MAX(a.agent_matricule) as agent_matricule,
                MAX(a.agent_nom) as agent_nom,
                MAX(a.agent_prenom) as agent_prenom,
                MAX(pa.patient_code) as patient_code,
                MAX(pa.patient_nom) as patient_nom,
                MAX(pa.patient_prenom) as patient_prenom
            FROM prescriptions AS pe
            INNER JOIN consultations AS cs ON pe.consult_id = cs.id
            INNER JOIN hopital_emplacements AS e ON pe.hopital_emplacement_id = e.id
            INNER JOIN patients AS pa ON cs.patient_id = pa.id
            INNER JOIN agents AS a ON cs.agent_id = a.id
            WHERE pe.hopital_emplacement_id = ? AND pe.prescription_status = ?
            GROUP BY cs.id;
        ',[$emplacementId, 'actif']);
        return response()->json([
            "status"=>"success",
            "prescriptions"=>$prescriptions
        ]);
    }


    /**
     * Voir les consultations passées du patient
     * @param int $patientId
     * @param int $hopitalId
     * @return JsonResponse
     */
    public function viewMedicalDocs(int $patientId, int $hopitalId): JsonResponse
    {
        $dossiers = Consultations::with('agent')
            ->with('patient.details', function ($query){
                return $query->orderByDesc('id');
            })
            ->with('signe')
            ->with('prescriptions.produit.categorie')
            ->with('prescriptions.produit.type')
            ->with('antecedents')
            ->with('symptomes')
            ->with('examens.examen')
            ->where('patient_id', $patientId)
            ->where('hopital_id', $hopitalId)
            ->orderByDesc('consult_create_At')
            ->get();
        return response()->json([
            "status"=>"success",
            "dossiers"=>$dossiers
        ]);
    }

    /**
     * Schedule create
     * @author Gaston delimond
     * @param Request $request
     * @return JsonResponse
    */
    public function createSchedule(Request $request):JsonResponse
    {
        try{
            $data = $request->validate([
                'schedule_date_heure'=>'required|date|after:now',
                'schedule_duree'=>'nullable|int',
                'schedule_note'=>'nullable|string',
                'agent_id'=>'required|int|exists:agents,id',
                'patient_id'=>'required|int|exists:patients,id',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            $schedule= MedicalSchedule::create($data);
            if(isset($schedule)){
                return response()->json([
                    "status"=>"success",
                    "result"=>$schedule
                ]);
            }
            else{
                return response()->json(['errors' => "Echec de traitement de la requête" ]);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }

    /**
     * view all Schedules
     * @author Gaston delimond
     * @param Request $request
     * @return JsonResponse
     */
    public function viewAllSchedules(int $emplacementId):JsonResponse
    {
        $schedules = MedicalSchedule::with('agent')
            ->with('patient')
            ->where('hopital_emplacement_id', $emplacementId)
            ->where('schedule_status', 'actif')
            ->get();
        return response()->json([
            "status"=>"success",
            "schedules"=>$schedules
        ]);
    }

    /**
     * Voir le traitement pour un patient
     * @param int $patientId
     * @return JsonResponse
     */
    public function showPatientTraitments(int $patientId)
    {
        $consultation = Consultations::where('patient_id', $patientId)->orderByDesc('id')
            ->first();
        $prescriptions = [];
        if(isset($consultation)){
            $prescriptions = Prescriptions::with('produit')
                ->with('user.agent')
                ->with('consultation')
                ->where('consult_id', $consultation->id)
                ->get();
        }
        return response()->json([
            "status"=>"success",
            "prescriptions"=>$prescriptions
        ]);
    }

    /**
     * Effectuer un traitement à un patient
     * @param Request $request
     * @return JsonResponse
    */
    public function makeTraitement(Request $request):JsonResponse
    {
        try{
            $data = $request->validate([
                'traitements'=>"required|array",
                'patient_id'=>'required|int|exists:patients,id',
                'hopital_id'=>'required|int|exists:hopitals,id',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'created_by'=>'required|int|exists:users,id',
                'agent_id'=>'required|int|exists:agents,id',
                "suivi_etat"=>"required|string",
                "suivi_obs"=>"nullable|string",
                "suivi_recommandations"=>"nullable|string",
            ]);
            $traitements =$data['traitements'];
            $suivi = PatientSuivi::create([
                "suivi_etat"=>$data["suivi_etat"],
                "suivi_obs"=>$data["suivi_obs"],
                "suivi_recommandations"=>$data["suivi_recommandations"],
                'patient_id'=> $data['patient_id'],
                'created_by'=> $data['created_by'],
                'agent_id'=> $data['agent_id'],
                'hopital_id'=> $data['hopital_id'],
                'hopital_emplacement_id'=> $data['hopital_emplacement_id'],
            ]);
            foreach ($traitements as $item){
                $item['patient_id']= $data['patient_id'];
                $item['created_by']= $data['created_by'];
                $item['agent_id']= $data['agent_id'];
                $item['hopital_id']= $data['hopital_id'];
                $item['hopital_emplacement_id']= $data['hopital_emplacement_id'];
                $item['suivi_id']= $suivi->id;
                PatientTraitement::create($item);
            }

            return response()->json([
                "status"=>"success",
                "message"=>"Traitement et suivi effectué avec succès !"
            ]);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }



    /**
     * Clôturer la session du traitement du patient
     * @param Request $request
     * @return JsonResponse
     */
    public function closeTraitementSession($patientID)
    {
        $patient = Patients::find($patientID);
        $patient->patient_traitement_status = null;
        $patient->save();
        return response()->json([
            "status"=>"success",
            "patient"=>$patient
        ]);
    }

    /**
     * Voir les traitements effectués aux patients
     * @param int $userId
     * @param int $emplacementId
     * @return JsonResponse
     */
    public function viewAllSuivis(int $emplacementId):JsonResponse
    {
        $suivis = [];
        $results = Patients::with(['suivis.traitements.prescription','suivis.traitements.prescription.produit.type','suivis.traitements.prescription.produit.categorie', 'suivis.traitements.prescription.user.agent', 'suivis.agent'])
            ->where('hopital_emplacement_id', $emplacementId)
            ->get();
        foreach ($results as $value) {
            if(count($value->suivis) >0){
                $suivis[] = $value;
            }
        }
        return response()->json([
            "status"=>"success",
            "suivis"=>$suivis
        ]);
    }

    private function getRandomCode(int $length=null)
    {
        $lettreAleatoire = chr(rand(65, 90));
        $chiffresAleatoires = str_pad(rand(0, 9999), $length ?? 4, '0', STR_PAD_LEFT);
        $codeGenerer = $lettreAleatoire . $chiffresAleatoires;
        return $codeGenerer;
    }

}