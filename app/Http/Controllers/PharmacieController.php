<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\Pharmacie;
use App\Models\Produit;
use App\Models\ProduitCategorie;
use App\Models\ProduitPrice;
use App\Models\ProduitType;
use App\Models\ProduitUnite;
use App\Models\Stock;
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
     * Creation des Categories des produits
     * @param Request $request httpRequest data
     * @return JsonResponse
    */
    public function createCategory(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'categorie_libelle'=>'required|string',
                'categorie_description'=>'nullable|string',
                'hopital_id'=>'required|int|exists:hopitals,id',
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
     * Creation des Types des produits
     * @param Request $request httpRequest data
     * @return JsonResponse
    */
    public function createType(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'type_libelle'=>'required|string',
                'type_description'=>'nullable|string',
                'hopital_id'=>'required|int|exists:hopitals,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            //Cree une categorie dans la base de données !
            $result = ProduitType::create($data);
            return response()->json([
                "status"=>"success",
                "type"=>$result
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
     * Creation des fournisseurs
     * @param Request $request httpRequest data
     * @return JsonResponse
     */
    public function createFournisseur(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'nom'=>'required|string',
                'adresse'=>'required|string',
                'email'=>'nullable|email',
                'telephone'=>'nullable|string',
                'hopital_id'=>'required|int|exists:hopitals,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            //Cree une categorie dans la base de données !
            $result = Fournisseur::create([
                'fournisseur_nom'=>$data['nom'],
                'fournisseur_adresse'=>$data['adresse'],
                'fournisseur_email'=>$data['email'],
                'fournisseur_telephone'=>$data['telephone'],
                'hopital_id'=>$data['hopital_id'],
                'created_by'=>$data['created_by']
            ]);
            return response()->json([
                "status"=>"success",
                "fournisseur"=>$result
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
     * Creation des unites des produits
     * @param Request $request httpRequest data
     * @return JsonResponse
    */
    public function createUnite(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'unite_libelle'=>'required|string',
                'unite_description'=>'nullable|string',
                'hopital_id'=>'required|int|exists:hopitals,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            //Cree une categorie dans la base de données !
            $result = ProduitUnite::create($data);
            return response()->json([
                "status"=>"success",
                "type"=>$result
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
    public function createProduct(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'produit_libelle'=>'required|string',
                'produit_code'=>'required|string|unique:produits,produit_code',
                'produit_description'=>'nullable|string',
                'produit_stock_min'=>'required|int',
                'categorie_id'=>'required|int|exists:produit_categories,id',
                'unite_id'=>'required|int|exists:produit_unites,id',
                'type_id'=>'required|int|exists:produit_types,id',
                'hopital_id'=>'required|int|exists:hopitals,id',
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

    /**
     * Ajoute les prix pour les produits dans la pharmacie
     * @param Request $request HttpRequest data
     * @return JsonResponse
     */
    public function addProductPrice(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                "produit_prix"=>"required|numeric",
                "produit_prix_devise"=>"nullable|string",
                "pharmacie_id"=>"required|int|exits:pharmacies,id",
                "produit_id"=>"required|int|exits:produits,id",
            ]);
            //Cree un produit dans la base de données !
            $result = ProduitPrice::create($data);
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




    /**
     * Create new stock
     * @param Request $request HttpRequest data
     * @return JsonResponse
     */
    public function createStock(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'stock_qte'=>'required|integer|gt:0',
                'stock_date_exp'=>'required|date|after:now',
                'emplacement'=>'nullable|string',
                'produit_id'=>'required|int|exists:produits,id',
                'fournisseur_id'=>'required|int|exists:fournisseurs,id',
                'pharmacie_id'=>'required|int|exists:pharmacies,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            //Cree un produit dans la base de données !
            $result = Stock::create($data);
            return response()->json([
                "status"=>"success",
                "stock"=>$result
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
     * View all Configs(categories, types, unites)
     * @param int $hopitalId
     * @return JsonResponse
     */
    public function allConfig(int $hopitalId):JsonResponse
    {
        $categories = ProduitCategorie::with('hopital')->where('hopital_id', $hopitalId)->get();
        $types = ProduitType::with('hopital')->where('hopital_id', $hopitalId)->get();
        $unites = ProduitUnite::with('hopital')->where('hopital_id', $hopitalId)->get();
        $fournisseurs = Fournisseur::with('hopital')->where('hopital_id', $hopitalId)->get();
        $pharmacies = Pharmacie::with('hopital')
            ->with('emplacement')
            ->where('hopital_id', $hopitalId)->get();
        $produits = Produit::with('hopital')
            ->with('categorie')
            ->with('type')
            ->with('unite')
            ->where('hopital_id', $hopitalId)->get();
        return response()->json([
            "status"=>"success",
            "datas"=>[
                "categories"=>$categories,
                "types"=>$types,
                "unites"=>$unites,
                "fournisseurs"=>$fournisseurs,
                "produits"=>$produits,
                "pharmacies"=>$pharmacies
            ]
        ]);
    }
}
