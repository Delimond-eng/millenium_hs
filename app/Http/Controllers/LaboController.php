<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboController extends Controller
{
    /**
     * labo voir toutes les demandes des examens labo
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
}
