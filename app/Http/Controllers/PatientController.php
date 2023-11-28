<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\PatientDetail;
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
    public function all($order='desc'): JsonResponse
    {
        $agents = Patients::with('details')
            ->with('agent')->orderBy(column: 'id', direction: $order)
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
                    'created_by'=> 'required|int|exists:agents,id',
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
                    'created_by'=>$data['created_by'],
                ]);
                if(isset($patient) && (isset($patientDetails) && !empty($patientDetails))){
                    $details = PatientDetail::create([
                        "patient_detail_poids"=> $patientDetails['poids'],
                        "patient_detail_taille"=> $patientDetails['taille'],
                        "patient_detail_temperature"=> $patientDetails['temperature'],
                        "patient_detail_age"=> $patientDetails['age'],
                        "patient_tension_art"=> $patientDetails['tension_art'],
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
                $details = PatientDetail::create([
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



    public function assign(Request $request): JsonResponse{
        try
        {
            $data = $request->validate([
                'agent_id' => 'required|int|exists:agents,id',
                'patient_id' => 'required|int|exists:patients,id',
            ]);
            /** @var mixed create agent */
            $assignDatas = Assign::create([
                'assign_agent_id' => $data['agent_id'],
                'assign_patient_id' => $data['patient_id'],
            ]);
            return response()->json([
                "status"=>"success",
                "patients"=>$assignDatas
            ]);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
