<?php

namespace App\Http\Controllers;
use App\Models\FacturePaiement;
use App\Models\Paiement;
use App\Models\PatientSignesVitaux;
use App\Models\Patients;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $locationId
     * @return JsonResponse
     */
    public function all($locationId): JsonResponse
    {
        $patients = Patients::with('details')
            ->with('agent')->orderBy(column: 'id', direction: 'desc')
            ->where('hopital_emplacement_id', $locationId)
            ->get();
        return response()->json([
            "status"=>"success",
            "patients"=>$patients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try
        {
            $patientDetails= $request->patient_details;
            /**
             * Verifie si le patient exist
            */
            if(!isset($request->patient_id)){
                /** @var mixed check validate datas */
                $data = $request->validate([
                    'code'=>'required|string|unique:patients,patient_code',
                    'nom' => 'required|string',
                    'code_appel' => 'required|string',
                    'prenom' => 'required|string',
                    'sexe' => 'required|string|max:1',
                    'datenais' => 'required|date|date_format:Y-m-d',
                    'groupe_sang' => 'nullable|string',
                    'etat_civil' => 'nullable|string',
                    'num_assurance' => 'nullable|string|exists:partener_agents,agent_num_convention',
                    'telephone' => 'required|string|min:10|unique:patients,patient_telephone',
                    'telephone_urgence' => 'nullable|string|min:10',
                    'adresse' => 'required|string',
                    'created_by'=> 'required|int',
                    'emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                    'hopital_id'=>'required|int|exists:hopitals,id',
                    'paiement'=>'required|array',
                    'paiement.montant'=>'required|numeric'
                ]);
                /** @var mixed create agent */
                $patient = Patients::create([
                    'patient_code' => $request->code,
                    'patient_code_appel'=> $data['code_appel'],
                    'patient_nom' => $data['nom'],
                    'patient_prenom' => $data['prenom'],
                    'patient_sexe' => $data['sexe'],
                    'patient_telephone' => $data['telephone'],
                    'patient_contact_urgence'=>$data['telephone_urgence'],
                    'patient_adresse' => $data['adresse'],
                    'patient_datenais' => $data['datenais'],
                    'patient_etat_civil' => $data['etat_civil'],
                    'patient_gs' => $data['groupe_sang'],
                    'patient_num_assurance' => $data['num_assurance'],
                    'hopital_emplacement_id'=>$data['emplacement_id'],
                    'hopital_id'=>$data['hopital_id'],
                    'created_by'=>$data['created_by'],
                ]);

                if(isset($patient)){
                    $details = PatientSignesVitaux::create([
                        "patient_sv_poids"=> $patientDetails['poids'],
                        "patient_sv_taille"=> $patientDetails['taille'],
                        "patient_sv_temperature"=> $patientDetails['temperature'],
                        "patient_sv_age"=> $patientDetails['age'],
                        "patient_sv_tension_art"=> $patientDetails['tension_art'],
                        "patient_sv_freq_cardio"=> $patientDetails['freq_cardio'],
                        "patient_sv_saturation"=> $patientDetails['saturation'],
                        'hopital_emplacement_id'=>$data['emplacement_id'],
                        'hopital_id'=>$data['hopital_id'],
                        "patient_id"=> $patient->id,
                        'created_by'=>$data['created_by'],
                    ]);
                    //Enregistrement d'un paiement de la fiche de consultation
                    $paiementDatas = [
                        "paiement_montant"=>$request->paiement['montant'],
                        "paiement_montant_devise"=>$request->paiement['devise'],
                        "facturation_id"=>$request->paiement['facturation_id'],
                        "patient_id"=>$patient->id,
                        'hopital_emplacement_id'=>$data['emplacement_id'],
                        'hopital_id'=>$data['hopital_id'],
                        'created_by'=>$data['created_by'],
                    ];
                    $paiement = $this->makeFichePaiement($paiementDatas);
                    $patient['details'] = $details;
                    $patient['paiement'] = $paiement;
                }
                return response()->json([
                    "status"=>"success",
                    "patient"=>$patient
                ]);
            }
            else{
                $data = $request->validate([
                    'paiement'=>'required|array',
                    'paiement.montant'=>'required|numeric'
                ]);
                /** @var mixed affiche les infos de l'ancien patient */
                $oldPatient = Patients::find((int)$request->patient_id);

                $currentStatus = $oldPatient->patient_traitement_status;
                if($currentStatus !== null){
                    return response()->json(['errors' => 'Patient sous traitement déjà, veuillez changer son status dans le sous menu `patients sous traitement` pour créer une nouvelle visite ! !']);
                }

                //Verification si le patient a deja un status en cours
                $sv = PatientSignesVitaux::where('patient_id', $oldPatient->id)->whereNull("consult_id")->first();
                if(isset($sv)){
                    return response()->json(['errors' => 'Ce patient a déjà une consultation en cours !']);
                }
                $details = PatientSignesVitaux::create([
                    "patient_sv_poids"=> $patientDetails['poids'],
                    "patient_sv_taille"=> $patientDetails['taille'],
                    "patient_sv_temperature"=> $patientDetails['temperature'],
                    "patient_sv_age"=> $patientDetails['age'],
                    "patient_sv_tension_art"=> $patientDetails['tension_art'],
                    "patient_sv_freq_cardio"=> $patientDetails['freq_cardio'],
                    "patient_sv_saturation"=> $patientDetails['saturation'],
                    'hopital_emplacement_id'=>$request->emplacement_id,
                    "hopital_id"=> $request->hopital_id,
                    "patient_id"=> $request->patient_id,
                    'created_by'=> $request->created_by,
                ]);

                $oldPatient->patient_code_appel = $request->code_appel;
                $oldPatient->save();
                $oldPatient["details"] = $details;
                //Enregistrement d'un paiement de la fiche de consultation
                $paiementDatas = [
                    "paiement_montant"=>$request->paiement['montant'],
                    "paiement_montant_devise"=>$request->paiement['devise'],
                    "facturation_id"=>$request->paiement['facturation_id'],
                    'hopital_emplacement_id'=>$request->emplacement_id,
                    "hopital_id"=> $request->hopital_id,
                    "patient_id"=> $request->patient_id,
                    'created_by'=> $request->created_by,
                ];
                $paiement = $this->makeFichePaiement($paiementDatas);
                $oldPatient['paiement'] = $paiement;
                return response()->json([
                    "status"=>"success",
                    "patient"=>$oldPatient,
                ]);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\ErrorException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }

    }


    /**
     * UPDATE PATIENT STATUS
     * @param $data
     * @return boolean
     */
    public function updateStatus($data):bool{
        $fiche = PatientSignesVitaux::where('id', $data['patient_sv_id'])->firstOrFail();
        $fiche->patient_fiche_status = $data["status"];
        $result = $fiche->save();
        return $result;
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        $patient = Patients::where('id', $id)->with('details')->first();
        return response()->json([
            "status"=>"success",
            "patient"=>$patient
        ]);
    }

    /**
     * Voir la liste de tous les patients dont leur status est en attente
     * @param int $emplacementId
     * @return JsonResponse
     */
    public function viewAllPendingPatients(int $emplacementId):JsonResponse{
        $patients = Patients::join('patient_signes_vitaux', 'patients.id', '=', 'patient_signes_vitaux.patient_id')
            ->whereNull('patient_signes_vitaux.consult_id')
            ->whereNull('patient_traitement_status')
            ->where('patients.hopital_emplacement_id', $emplacementId)
            ->select('patients.*')
            ->with('details')
            ->orderBy('patients.id', 'asc')
            ->get();
        return response()->json([
            "status"=>"success",
            "patients"=>$patients
        ]);
    }


    /**
     * Voir la liste de tous les patients dont leur status est en attente
     * @param int $emplacementId
     * @return JsonResponse
     */
    public function viewPatientsSousTraitement(int $emplacementId):JsonResponse{
        $patients = Patients::with('details')
            ->whereNot('patient_traitement_status', null)
            ->where('patients.hopital_emplacement_id', $emplacementId)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            "status"=>"success",
            "patients"=>$patients
        ]);
    }


    /**
     * Parcourir le dossier medical du patient
     * @param int patientId
     * @return JsonResponse
    */
    public function viewMedicalStory(int $patientId):JsonResponse
    {
        $results = Patients::with('consultations.prescriptions')
                        ->with('consultations.antecedents')
                        ->with('consultations.symptomes')
                        ->with('consultations.examens')
                        ->with('consultations', function($query){
                            return $query->orderByDesc('consult_create_At');
                        })
                        ->where('id', $patientId)
                        ->first();

        return response()->json([
            "status"=>"success",
            "result"=>$results
        ]);
    }

    /**
     * Paiement de la fiche medical
     * @author Gaston Delimond
     * @param $data
     * @return mixed
    */
    private function makeFichePaiement($data):mixed
    {
        $result = FacturePaiement::create([
            "paiement_montant"=>$data['paiement_montant'],
            "paiement_montant_devise"=>$data['paiement_montant_devise'],
            "facturation_id"=>$data['facturation_id'],
            "patient_id"=>$data['patient_id'],
            "hopital_id"=>$data['hopital_id'],
            "hopital_emplacement_id"=>$data['hopital_emplacement_id'],
            "created_by"=>$data['created_by'],
        ]);
        if(isset($result)){
            return $result;
        }
        else {
            return null;
        }
    }





    /**
     * Génerer un code unique
     * @return JsonResponse
     */
    public function getCode() :JsonResponse{
        $lettreAleatoire = chr(rand(65, 90));
        $chiffresAleatoires = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $codeGenerer = $lettreAleatoire . $chiffresAleatoires;
        return response()->json([
            "code"=>$codeGenerer,
        ]);
    }
}