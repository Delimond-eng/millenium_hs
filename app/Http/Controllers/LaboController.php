<?php

namespace App\Http\Controllers;

use App\Models\Laboratoire;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LaboController extends Controller
{
    /**
     * labo voir toutes les demandes des examens labo
     * @param  $emplacementId
     * @return JsonResponse
    */
    public function viewAllLaboExamens($emplacementId):JsonResponse
    {
        $examens = DB::select(/** @lang text */ '
            SELECT
                MAX(c.consult_examen_create_At) as consult_examen_create_At,
                MAX(c.consult_examen_status) as consult_examen_status,
                MAX(c.patient_id) as patient_id,
                MAX(c.consult_id) as consult_id,
                MAX(c.agent_id) as agent_id,
                MAX(e.hopital_emplacement_libelle) as hopital_emplacement_libelle,
                MAX(a.agent_nom) as agent_nom,
                MAX(p.patient_nom) as patient_nom
            FROM consultation_examens AS c
            INNER JOIN consultations AS cs ON c.consult_id = cs.id
            INNER JOIN hopital_emplacements AS e ON c.hopital_emplacement_id = e.id
            INNER JOIN agents AS a ON c.agent_id = a.id
            INNER JOIN patients AS p ON c.patient_id = p.id
            WHERE c.hopital_emplacement_id = ? AND c.consult_examen_status = ?
            GROUP BY cs.id;
        ',[$emplacementId, 'validé']);
        return response()->json([
            "status"=>"success",
            "examens"=>$examens
        ]);
    }

    /**
     * Creer un nouveau laboratoire
     * @param Request $request
     * @return JsonResponse
    */
    public function createLabo(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'labo_nom'=>'required|string|unique:laboratoires,labo_nom',
                'labo_adresse'=>'required|string',
                'labo_telephone'=>'nullable|string',
                'hopital_id'=>'required|int|exists:hopitals,id',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'created_by'=>'required|int|exists:users,id'
            ]);
            $result = Laboratoire::create($data);
            if(isset($result)){
                return response()->json([
                    "status"=>"success",
                    "result"=>$result,
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
     * Voir tous les laboratoire par Emplacement ou par Hopital
     * @param null $hopitalId
     * @return JsonResponse
     */
    public function allLabos($hopitalId):JsonResponse
    {
        $results = Laboratoire::with('emplacement')->where('hopital_id', $hopitalId)->get();
        return response()->json([
            "status"=>"success",
            "labos"=>$results
        ]);
    }
}
