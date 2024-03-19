<?php

namespace App\Http\Controllers;

use App\Models\Hospitalisation;
use App\Models\HospitalisationLit;
use App\Models\HospitalisationTransfert;
use App\Models\LitType;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HospitalisationController extends Controller
{

    /**
     * CREATE BED TYPE
     * @author Gaston delimond
     * @param Request $request
     * @return JsonResponse
     */
    public function createBedType(Request $request):JsonResponse
    {
        try {
            $datas = $request->validate([
                'type_libelle'=>'required|string',
                'type_description'=>'nullable|string',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            $result = LitType::create($datas);
            return $this->sendResult($result);
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
     * CREATE BED OR CONFIGURATION
     * @author Gaston delimond
     * @param Request $request
     * @return JsonResponse
    */
    public function createBed(Request $request):JsonResponse
    {
        try {
            $datas = $request->validate([
                'lit_numero'=>'required|string|unique:hospitalisation_lits,lit_numero',
                'lit_status'=>'nullable|string',
                'type_id'=>'required|int|exists:lit_types,id',
                'service_id'=>'required|int|exists:services,id',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'created_by'=>'required|int|exists:users,id',
            ]);

            $result = HospitalisationLit::create($datas);
            return $this->sendResult($result);
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
     * CREATE NEW HOSPITALISATION
     * @author Gaston delimond
     * @param Request $request
     * @return JsonResponse
    */
    public function createHospitalisation(Request $request):JsonResponse
    {
        try {
            $datas = $request->validate([
                'hospitalisation_start_At'=>'required|date_format:Y-m-d H:i',
                'hospitalisation_end_At'=>'required|date_format:Y-m-d H:i',
                'hospitalisation_raison_admission'=>'required|string',
                'patient_id'=>'required|int|exists:patients,id',
                'lit_id'=>'required|int|exists:hospitalisation_lits,id',
                'service_responsable_id'=>'required|int|exists:services,id',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            $isValidDates = $this->checkDateSuper($datas['hospitalisation_start_At'], $datas['hospitalisation_end_At']);
            if(!$isValidDates){
                return response()->json(['errors' => 'La date et heure fin admission doit être supérieure à la date & heure début admission !' ]);
            }
            $result = Hospitalisation::create($datas);
            if(isset($result)){
                $lit = HospitalisationLit::findOrFail($result->lit_id);
                $lit->lit_status='occupé';
                $lit->save();
            }
            return $this->sendResult($result);
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
     * CREATE PATIENT BED TRANSFERT
     * @author Gaston delimond
     * @param Request $request
     * @return JsonResponse
    */
    public function createBedTransfert(Request $request):JsonResponse
    {
        try {
            $datas = $request->validate([
                'hospitalisation_id'=>'required|int|exists:hospitalisations,id',
                'lit_origine_id'=>'required|int|exists:hospitalisation_lits,id',
                'lit_destination_id'=>'required|int|exists:hospitalisation_lits,id|different:lit_origine_id',
                'transfert_date_heure'=>'required|date_format:Y-m-d H:i',
                'transfert_raison'=>'required|string',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            $result = HospitalisationTransfert::create($datas);
            if(isset($result)){
                //RETABLIR LE STATUS DU LIT D'ORIGINE EN DISPONIBLE
                $lit1 = HospitalisationLit::findOrFail((int)$datas['lit_origine_id']);
                $lit1->lit_status="disponible";
                $lit1->save();

                //ASSIGNER L'IDENTIFIANT DU NOUVEAU LIT
                $lit2 = Hospitalisation::findOrFail($result->id);
                $lit2->lit_id=(int)$datas['lit_destination_id'];
                $lit2->save();

                //RENDRE OCCUPER LE LIT DU D'ORIGINE
                $lit3 = HospitalisationLit::findOrFail((int)$datas['lit_destination_id']);
                $lit3->lit_status="occupé";
                $lit3->save();
            }
            return $this->sendResult($request);
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
     * GET ALL DATAS
     * @return JsonResponse
    */
    public function viewAllDatas($emplacementId):JsonResponse
    {
        $types = LitType::with('emplacement.hopital')
            ->with('user')
            ->where('hopital_emplacement_id', $emplacementId)
            ->get();
        $lits = HospitalisationLit::with('type')
            ->with('user')
            ->with('service')
            ->with('emplacement.hopital')
            ->where('hopital_emplacement_id', $emplacementId)
            ->get();
        $litDispos =  HospitalisationLit::with('type')
            ->with('user')
            ->with('service')
            ->with('emplacement.hopital')
            ->where('hopital_emplacement_id', $emplacementId)
            ->where('lit_status', 'disponible')
            ->get();
        $transferts = HospitalisationTransfert::with('hospitalisation.patient')
            ->with('hospitalisation.agent')
            ->with('origine')
            ->with('destination')
            ->with('emplacement.hopital')
            ->with('user')
            ->where('hopital_emplacement_id', $emplacementId)
            ->get();
        $hospitalisations = Hospitalisation::with('patient')
            ->with('lit.type')
            ->with('lit.service')
            ->with('agent')
            ->with('emplacement.hopital')
            ->with('user')
            ->where('hospitalisation_status', 'actif')
            ->orWhere('hospitalisation_status', 'cloturé')
            ->get();
        foreach ($hospitalisations as $hospitalisation) {
            $startAt = $hospitalisation->hospitalisation_start_At;
            $endAt = $hospitalisation->hospitalisation_end_At;
            $differenceInHours = $startAt->diffInDays($endAt);
            $hospitalisation->count = $differenceInHours;
            if ($endAt->isFuture()) {
                $difference = $endAt->diff(Carbon::now());
                $daysRemaining = $difference->days;
                $hospitalisation->count_rest = $daysRemaining;
            } else {
                $hospitalisation->count_rest = 0;
            }
        }
        return response()->json([
            "types" => $types,
            "lits"=>$lits,
            "litDispos"=>$litDispos,
            "transferts"=>$transferts,
            "hospitalisations"=>$hospitalisations
        ]);
    }

    /**
     * REUSABLE METHOD ALLOW TO SEND JSON AFTER REQUEST
     * @param $result
     * @return JsonResponse
    */
    private function sendResult($result):JsonResponse{
        if(isset($result)){
            return response()->json([
                "status"=>"success",
                "result"=>$result
            ]);
        }
        else{
            return response()->json(['errors' => 'Echec de traitement de la requête !' ]);
        }

    }


    private function checkDateSuper($dateStart, $dateEnd): bool
    {
        $dateTimeStart = Carbon::parse($dateStart);
        $dateTimeEnd = Carbon::parse($dateEnd);
        return $dateTimeEnd->gt($dateTimeStart);
    }



}
