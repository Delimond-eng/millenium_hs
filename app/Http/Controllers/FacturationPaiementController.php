<?php

namespace App\Http\Controllers;

use App\Models\FacturePaiement;
use App\Models\Paiement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FacturationPaiementController extends Controller
{
    /**
     * Affichage de l'historique des paiements par hopital ou par Emplacement
     * @param string|null $key,
     * @param int $id
     * @return JsonResponse
    */
    public function viewAllPaiement(int $id, string $key=null) : JsonResponse
    {
        $paiements = match ($key){
            "all"=>FacturePaiement::with('facturation')
                ->with('patient')
                ->with('emplacement')
                ->with('hopital')
                ->with('user.agent')
                ->where('hopital_id', $id)
                ->get(),
            default =>FacturePaiement::with('facturation')
                ->with('patient')
                ->with('emplacement')
                ->with('hopital')
                ->with('user.agent')
                ->where('hopital_emplacement_id', $id)
                ->get()
        };

        return response()->json([
            "status"=>"success",
           "paiements"=>$paiements
        ]);
    }
}
