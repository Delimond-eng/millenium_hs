<?php

namespace App\Http\Controllers;
use App\Models\PatientFiche;
use App\Models\Patients;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
                    'nom' => 'required|string',
                    'code_appel' => 'required|string',
                    'prenom' => 'required|string',
                    'sexe' => 'required|string|max:1',
                    'datenais' => 'required|date|date_format:Y-m-d',
                    'groupe_sang' => 'nullable|string',
                    'etat_civil' => 'nullable|string',
                    'num_assurance' => 'nullable|string',
                    'telephone' => 'required|string|min:10|unique:patients,patient_telephone',
                    'adresse' => 'required|string',
                    'created_by'=> 'required|int',
                    'emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                    'hopital_id'=>'required|int|exists:hopitals,id',
                ]);
                /** @var mixed create agent */
                $patient = Patients::create([
                    'patient_code' => $request->code,
                    'patient_code_appel'=> $data['code_appel'],
                    'patient_nom' => $data['nom'],
                    'patient_prenom' => $data['prenom'],
                    'patient_sexe' => $data['sexe'],
                    'patient_telephone' => $data['telephone'],
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
                    $details = PatientFiche::create([
                        "patient_fiche_poids"=> $patientDetails['poids'],
                        "patient_fiche_taille"=> $patientDetails['taille'],
                        "patient_fiche_temperature"=> $patientDetails['temperature'],
                        "patient_fiche_age"=> $patientDetails['age'],
                        "patient_fiche_tension_art"=> $patientDetails['tension_art'],
                        "patient_fiche_freq_cardio"=> $patientDetails['freq_cardio'],
                        "patient_fiche_saturation"=> $patientDetails['saturation'],
                        'hopital_emplacement_id'=>$data['emplacement_id'],
                        'hopital_id'=>$data['hopital_id'],
                        "patient_id"=> $patient->id,
                        'created_by'=>$data['created_by'],
                    ]);
                    $patient['details'] = $details;
                }
                return response()->json([
                    "status"=>"success",
                    "patient"=>$patient
                ]);
            }
            else{
                /** @var mixed affiche les infos de l'ancien patient */
                $oldPatient = Patients::where('id', $request->patient_id)->first();
                $details = PatientFiche::create([
                    "patient_fiche_poids"=> $patientDetails['poids'],
                    "patient_fiche_taille"=> $patientDetails['taille'],
                    "patient_fiche_temperature"=> $patientDetails['temperature'],
                    "patient_fiche_age"=> $patientDetails['age'],
                    "patient_fiche_tension_art"=> $patientDetails['tension_art'],
                    "patient_fiche_freq_cardio"=> $patientDetails['freq_cardio'],
                    "patient_fiche_saturation"=> $patientDetails['saturation'],
                    'hopital_emplacement_id'=>$request->emplacement_id,
                    "hopital_id"=> $request->hopital_id,
                    "patient_id"=> $request->patient_id,
                    'created_by'=> $request->created_by,
                ]);
                $oldPatient->patient_code_appel= $request->code_appel;
                $oldPatient->save();
                $oldPatient["details"] = $details;
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
        $fiche = PatientFiche::where('id', $data['patient_fiche_id'])->firstOrFail();
        $fiche->patient_fiche_status = $data["status"];
        $result = $fiche->save();
        return $result;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id) : JsonResponse
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
        /*$patients = Patients::with('details')->where('hopital_emplacement_id', $emplacementId)
            ->where('patient_fiche_status', 'en attente')
            ->get();*/
        $patients = Patients::join('patient_fiches', 'patients.id', '=', 'patient_fiches.patient_id')
            ->where('patient_fiches.patient_fiche_status', 'en attente')
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
     * Parcourir le dossier medical du patient
     * @param int patientId
     * @return JsonResponse
    */
    public function viewMedicalStory(int $patientId):JsonResponse
    {
        $results = Patients::with('consultations.prescriptions')
                        ->with('consultations.details')
                        ->with('consultations.symptomes')
                        ->with('consultations.examens')
                        ->where('id', $patientId)
                        ->first();

        return response()->json([
            "status"=>"success",
            "result"=>$results
        ]);
    }





    /**
     * Génerer un code unique
     * @return JsonResponse
     */
    public function getCode() :JsonResponse{
        $lettreAleatoire = chr(rand(65, 90)); // 65 représente le code ASCII de 'A' et 90 celui de 'Z'
        $chiffresAleatoires = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $codeGenerer = $lettreAleatoire . $chiffresAleatoires;
        return response()->json([
            "code"=>$codeGenerer,
        ]);
    }
}
