<?php

namespace App\Http\Controllers;

use App\Models\Pharmacie;
use App\Models\Produit;
use App\Models\ProduitCategorie;
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
            $pharmacieId = $request->pharmacie_id;
            /**
             * Save new
             */
            $data = $request->validate([
                "nom"=>"required|string",
                "adresse"=>"required|string",
                "telephone"=>"required|string|unique:pharmacies,pharmacie_telephone",
                "created_by"=> "required|int",
                'hopital_id'=> 'required|int|exists:hopitals,id',
                'emplacement_id'=> 'required|int|exists:hopital_emplacements,id',
            ]);
            /**
             * update exist
            */
            if(isset($pharmacieId)){
                $pharmacie = Pharmacie::findOrFail($pharmacieId);
                $pharmacie->pharmacie_nom = $data["nom"];
                $pharmacie->pharmacie_telephone = $data["telephone"];
                $pharmacie->pharmacie_adresse = $data["adresse"];
                $pharmacie->hopital_emplacement_id = $data["emplacement_id"];
                $pharmacie->created_by = $data['created_by'];
                $result = $pharmacie->save();
                return response()->json([
                    "status"=>"success",
                    "pharmacie"=>$result
                ]);

            }
            else{
                $result = Pharmacie::create([
                    "pharmacie_nom"=> $data["nom"],
                    "pharmacie_telephone"=> $data["telephone"],
                    "pharmacie_adresse"=> $data["adresse"],
                    "created_by"=> $data["created_by"],
                    'hopital_id'=>$data['hopital_id'],
                    'hopital_emplacement_id'=>$data['emplacement_id'],
                ]);
                return response()->json([
                    "status"=>"success",
                    "pharmacie"=>$result
                ]);
            }

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException | \ErrorException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }



    /**
     * Creation des produits pharmacetiques
     * @param Request $request httpRequest data
     * @return JsonResponse
    */
    public function createProduct(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'categorie_libelle'=>'required|string|unique:categorie,produit_libelle',
                'categorie_description'=>'nullable|string',
                'pharmacie_id'=>'required|int|exists:pharmacies,id',
                'hopital_id'=>'required|int|exists:hopitals,id',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            //Cree une categorie dans la base de données !
            $result = ProduitCategorie::create($data);
            return response()->json([
                "status"=>"success",
                "categorie"=>$result
            ]);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException | \ErrorException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }


    /**
     * Create new categorie
     * @param Request $request HttpRequest data
     * @return JsonResponse
    */
    public function createCategory(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'produit_libelle'=>'required|string|unique:produits,produit_libelle',
                'produit_code'=>'required|string|unique:produits,produit_code',
                'produit_prix_unitaire'=>'required|string',
                'produit_date_exp'=>'required|date_format:Y-m-d',
                'produit_stock_min'=>'required|int',
                'categorie_id'=>'required|int|exists:produit_categories,id',
                'pharmacie_id'=>'required|int|exists:pharmacies,id',
                'hopital_id'=>'required|int|exists:hopitals,id',
                'hopital_emplacement_id'=>'required|int|exists:hopital_emplacements,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            //Cree un produit dans la base de données !
            $result = Produit::create($data);
            return response()->json([
                "status"=>"success",
                "produit"=>$result
            ]);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException | \ErrorException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }
    }
}
