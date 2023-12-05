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
        $agents = Patients::with('details')
            ->with('agent')->orderBy(column: 'id', direction: 'desc')
            ->where('hopital_emplacement_id', $locationId)
            ->get();
        return response()->json([
            "status"=>"success",
            "patients"=>$agents
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
                    'prenom' => 'required|string',
                    'sexe' => 'required|string|max:1',
                    'datenais' => 'required|date|date_format:Y-m-d',
                    'telephone' => 'required|string|min:10|unique:patients,patient_telephone',
                    'adresse' => 'required|string',
                    'created_by'=> 'nullable|int',
                    'emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                    'hopital_id'=>'required|int|exists:hopitals,id',
                ]);
                /** @var mixed create agent */
                $patient = Patients::create([
                    'patient_code' => $request->code,
                    'patient_nom' => $data['nom'],
                    'patient_prenom' => $data['prenom'],
                    'patient_sexe' => $data['sexe'],
                    'patient_telephone' => $data['telephone'],
                    'patient_adresse' => $data['adresse'],
                    'patient_datenais' => $data['datenais'],
                    'hopital_emplacement_id'=>$data['emplacement_id'],
                    'hopital_id'=>$data['hopital_id'],
                    'created_by'=>$data['created_by'],
                ]);
                if(isset($patient) && (isset($patientDetails) && !empty($patientDetails))){
                    $details = PatientFiche::create([
                        "patient_fiche_poids"=> $patientDetails['poids'],
                        "patient_fiche_taille"=> $patientDetails['taille'],
                        "patient_fiche_temperature"=> $patientDetails['temperature'],
                        "patient_fiche_age"=> $patientDetails['age'],
                        "patient_fiche_tension_art"=> $patientDetails['tension_art'],
                        'hopital_emplacement_id'=>$data['emplacement_id'],
                        'hopital_id'=>$data['hopital_id'],
                        "patient_id"=> $patient->id,
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
                    "patient_detail_poids"=> $patientDetails['poids'],
                    "patient_detail_taille"=> $patientDetails['taille'],
                    "patient_detail_temperature"=> $patientDetails['temperature'],
                    "patient_detail_age"=> $patientDetails['age'],
                    "patient_tension_art"=> $patientDetails['tension_art'],
                    "patient_id"=> $request->patient_id,
                ]);
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

    }


    /**
     * UPDATE PATIENT STATUS
     * @param $data
     * @return boolean
    */
    private function updateStatus($data):bool{
        $patient = Patients::findOrFail($data['patient_id']);
        $patient->patient_status = $data['status'];
        return $patient->save();
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
        $patients = Patients::where('hopital_emplacement_id', $emplacementId)
            ->where('patient_status', 'en attente')
            ->get;
        return response()->json([
            "status"=>"success",
            "patients"=>$patients
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
