<?php

namespace App\Http\Controllers;

use App\Models\Pharmacie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PharmacieController extends Controller
{
    /**
     * Voir toutes les pharmacies d'un hopital
     * @param int $hostoId
     * @return JsonResponse
    */
    public function allPharmacies(int $hostoId):JsonResponse{
        $pharmacies = Pharmacie::with('emplacement')->where('hopital_id', $hostoId)->get();
        return response()->json([
            "status"=>"success",
            "pharmacies"=>$pharmacies
        ]);
    }

    /**
     * Voir les pharmacies pour un emplacement
     * @param int $emplacementId
     * @return JsonResponse
    */
    public function viewEmplacementPharmacies(int $emplacementId):JsonResponse{
        $pharmacies = Pharmacie::all()->where('hopital_emplacement_id', $emplacementId);
        return response()->json([
            "status"=>"success",
            "pharmacies"=>$pharmacies
        ]);
    }

    /**
     * CREER UNE NOUVELLE PHARMACIE POUR UN EMPLACEMENT
     * @param Request $request
     * @return JsonResponse
    */
    public function createPharmacie(Request $request):JsonResponse{
        try {
            $data = $request->validate([
                "nom"=>"required|string",
                "adresse"=>"required|string",
                "telephone"=>"nullable|string",
                "created_by"=> "nullable|int",
                'hopital_id'=> 'required|int|exists:hopitals,id',
                'emplacement_id'=> 'required|int|exists:hopital_emplacements,id',
            ]);
            $service = Pharmacie::create([
                "pharmacie_nom"=> $data["nom"],
                "pharmacie_telephone"=> $data["telephone"],
                "pharmacie_adresse"=> $data["adresse"],
                "created_by"=> $data["created_by"]??null,
                'hopital_id'=>$data['hopital_id'],
                'hopital_emplacement_id'=>$data['emplacement_id'],
            ]);
            return response()->json([
                "status"=>"success",
                "pharmacie"=>$service
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException | \ErrorException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }


}
