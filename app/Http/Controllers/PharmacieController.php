<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockInfoResource;
use App\Models\Fournisseur;
use App\Models\Pharmacie;
use App\Models\PharmacieClient;
use App\Models\PharmacieOperation;
use App\Models\Produit;
use App\Models\ProduitCategorie;
use App\Models\ProduitPrice;
use App\Models\ProduitType;
use App\Models\ProduitUnite;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PharmacieController extends Controller
{

    /**
     * Voir tous les utilisateurs liés à une pharmacie ou à une Gestion
     * @return JsonResponse
    */
    public function viewAllUsers():JsonResponse
    {
        $users = User::with('pharmacie')
            ->whereNot('pharmacie_id', null)
            ->whereNot('pharmacie_role', null)
            ->get();
        return response()->json([
            "status"=>"success",
            "users"=>$users
        ]);
    }
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
                'produit_stock_min'=>'nullable|int',
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
                "pharmacie_id"=>'required|int|exists:pharmacies,id',
                "produit_id"=>'required|int|exists:produits,id',
                "hopital_id"=>'required|int|exists:hopitals,id',
                "created_by"=>'required|int|exists:users,id',
            ]);
            //Cree un produit dans la base de données !
            $result = ProduitPrice::updateOrCreate(
                [
                    'produit_id'=>$data['produit_id'],
                    'pharmacie_id'=>$data['pharmacie_id']
                ],
                $data
            );
            return response()->json([
                "status"=>"success",
                "result"=>$result
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
                'stock_pa'=>'required|string',
                'stock_pa_devise'=>'nullable|string',
                'stock_obs'=>'nullable|string',
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
     * Voir tous les approvisionnements
     * @param int|null $pharmacieId
     * @return JsonResponse
     */
    public function viewAllStocks(int $pharmacieId=null): JsonResponse
    {
        $results = null;
        if(isset($pharmacieId)){
            $results = Stock::with('produit')
                ->with('fournisseur')
                ->with('pharmacie')
                ->with('user')
                ->where('pharmacie_id', $pharmacieId)
                ->where('stock_status', 'actif')
                ->get();
        }
        else{
            $results = Stock::with('produit')
                ->with('fournisseur')
                ->with('pharmacie')
                ->with('user')
                ->where('stock_status', 'actif')
                ->get();
        }
        return response()->json([
            "status"=>"success",
            "stocks"=>$results
        ]);
    }

    /**
     * View all Configs(categories, types, unites)
     * @param int $hopitalId
     * @param int|null $pharmacieId
     * @return JsonResponse
     */
    public function allConfig(int $hopitalId, int $pharmacieId = null):JsonResponse
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

        $productPrices = ProduitPrice::with('produit.categorie')
            ->with('produit.type')
            ->with('produit.unite')
            ->with('pharmacie')
            ->where('pharmacie_id', $pharmacieId)
            ->where('hopital_id', $hopitalId)
            ->get();
        return response()->json([
            "status"=>"success",
            "datas"=>[
                "categories"=>$categories,
                "types"=>$types,
                "unites"=>$unites,
                "fournisseurs"=>$fournisseurs,
                "produits"=>$produits,
                "productPrices"=>$productPrices,
                "pharmacies"=>$pharmacies
            ]
        ]);
    }


    /**
     * View pharmacie single product stock info
     * @param int $pharmacieID;
     * @param int $produitID
     * @return JsonResponse
    */
    public function viewProductStockInfos(int $produitID, int $pharmacieID): JsonResponse
    {
        $stocks = Stock::with("produit")
                            ->with('pharmacie')
                            ->where('produit_id', $produitID)
                            ->where('pharmacie_id', $pharmacieID)
                            ->get();
        $avgPa = $this->calculateAvgPrice($stocks);
        $info = isset($avgPa) ? [
            'stock_pa'=>$avgPa,
            'stock_pa_devise'=>'CDF',
        ] : null;
        return response()->json([
            "status"=>"success",
            "info"=> $info
        ]);
    }

    /**
     * Calcul le prix moyen d'achat de produit en fonction de tous les stocks y afferent
     * @param $stocks
     * @return float|int|null
     */
    private function calculateAvgPrice($stocks): float|int|null
    {
        $totalPrixAchat = 0;
        $nombreTotalStocks = count($stocks);
        foreach ($stocks as $stock) {
            $totalPrixAchat += (float)$stock->stock_pa;
        }
        if($totalPrixAchat !==0 && $nombreTotalStocks !== 0){
            return $totalPrixAchat / $nombreTotalStocks;
        }
        else{
            return null;
        }
    }

    /**
     * Save operation
     * @param Request $request
     * @return JsonResponse
     */
    public function saveOperation(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'operation_qte'=>'required|integer|gt:0',
                'operation_libelle'=>'required|string',
                'operation_obs'=>'nullable|string',
                'produit_id'=>'required|int|exists:produits,id',
                'pharmacie_id'=>'required|int|exists:pharmacies,id',
                'pharmacie_dest_id'=>'nullable|int|exists:pharmacies,id',
                'fournisseur_id'=>'nullable|int|exists:fournisseurs,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            $stockActif = $this->stockCountQte($data);
            $restStock = $stockActif - (int)$data['operation_qte'];
            if($restStock < 0){
                return response()->json(['errors' => 'Le stock actuel est inférieur à la quantité entrée !']);
            }
            $result = PharmacieOperation::create($data);
            if ($result['operation_libelle']=='transfert'){
                $stocks = Stock::with("produit")
                    ->with('pharmacie')
                    ->where('produit_id', $result['produit_id'])
                    ->where('pharmacie_id', $result['pharmacie_id'])
                    ->orderByDesc('id')
                    ->first();
                $transfered = Stock::create([
                    'stock_qte'=> $data['operation_qte'],
                    'stock_date_exp'=> $stocks['stock_date_exp'],
                    'stock_pa'=>$stocks['stock_pa'],
                    'stock_pa_devise'=>$stocks['stock_pa_devise'],
                    'stock_obs'=>$data['operation_obs'],
                    'produit_id'=>$stocks['produit_id'],
                    'fournisseur_id'=>$stocks['fournisseur_id'],
                    'pharmacie_id'=>$data['pharmacie_dest_id'],
                    'created_by'=>$data['created_by'],
                ]);
                return response()->json([
                    "status"=>"success",
                    "result"=>$result,
                    "transfered"=>$transfered
                ]);
            }
            else{
                return response()->json([
                    "status"=>"success",
                    "result"=>$result
                ]);
            }

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
     * all operations by status
     * @param string $key
     * @param int $pharmacieID
     * @return JsonResponse
     */
    public function allOperations(int $pharmacieID, string $key):JsonResponse
    {
        $datas = PharmacieOperation::with("produit.type")
            ->with('pharmacie')
            ->with('client')
            ->with('pharmacie_destination')
            ->with('fournisseur')
            ->with('user')
            ->where('operation_libelle',$key)
            ->where('pharmacie_id',$pharmacieID)
            ->where('operation_status','actif')
            ->get();
        return response()->json([
            "status"=>"success",
            "operations"=>$datas
        ]);
    }

    // Situation stock
    private function stockCountQte($data)
    {
        //Compte la somme de toutes les operations quantité sur les stocks des produits
        $qteOp = PharmacieOperation::with('pharmacie')
            ->where('produit_id', $data['produit_id'])
            ->where('pharmacie_id', $data['pharmacie_id'])
            ->sum('operation_qte');
        //Compte la somme de stocks quantité du produit de la pharmacie
        $qteStock = Stock::with('produit')
            ->where('produit_id',$data['produit_id'] )
            ->where('pharmacie_id',$data['pharmacie_id'])
            ->sum('stock_qte');
        return $qteStock - $qteOp;
    }

    /**
     * Voir les rapports des stocks
     * @param int $pharmacieID
     * @return JsonResponse
     */
    public function viewStocksReport(int $pharmacieID): JsonResponse
    {
        $stocks = Stock::selectRaw('produit_id, SUM(stock_qte) as qte_entree')
            ->where('pharmacie_id', $pharmacieID)
            ->groupBy('produit_id')
            ->get();

        $operations = PharmacieOperation::selectRaw('produit_id, SUM(operation_qte) as qte_sortie')
            ->where('pharmacie_id', $pharmacieID)
            ->groupBy('produit_id')
            ->get();

        $stockInfos = [];

        foreach ($stocks as $stock) {
            $qteSortie = $operations->where('produit_id', $stock->produit_id)->first()->qte_sortie ?? 0;

            $produit = Produit::find($stock->produit_id);

            $stockInfos[] = [
                'produit'=>$produit,
                'categorie'=>$produit->categorie,
                'qte_entree' => $stock->qte_entree,
                'qte_sortie' => $qteSortie,
            ];
        }

        return response()->json([
            "status"=>"success",
            "reports"=>$stockInfos
        ]);
    }

    /**
     * Verification de la disponibilité du client
     * @param int $pharmacieId
     * @param int $clientPhone
     * @return JsonResponse
     */
    public function checkClient(int $pharmacieId ,int $clientPhone):JsonResponse
    {
        $client = PharmacieClient::where('client_phone', 'LIKE', '%'.$clientPhone.'%')
            ->where('pharmacie_id', $pharmacieId)
            ->first();
        if(isset($client)){
            return response()->json([
                "status"=>"success",
                "client"=>$client
            ]);
        }else{
            return response()->json([
                "client"=>null
            ]);
        }
    }

    /**
     * Créer un client
     * @param Request $request
     * @return JsonResponse
    */
    public function createClient(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'client_nom'=>'required|string',
                'client_phone'=>'required|string|min:10',
                'pharmacie_id'=>'required|int|exists:pharmacies,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            $client = PharmacieClient::updateOrCreate(
                ["client_phone"=>$data['client_phone']],
                $data
            );
            return  response()->json([
                "status"=>"success",
                "client"=>$client
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
     * Permet de voir les produit
     * @param int $pharmacieID
     * @return JsonResponse
    */
    public function viewPharmacieProducts(int $pharmacieID): JsonResponse
    {
        $products = ProduitPrice::with('produit.categorie')
                    ->with('produit.type')
                    ->where('pharmacie_id', $pharmacieID)
                    ->get();

        foreach ($products as $product){
            $data = [
                "produit_id"=>$product->produit_id,
                "pharmacie_id" => $product->pharmacie_id
            ];
            $product->stock = $this->stockCountQte($data);
        }
        return response()->json([
            "status"=>"success",
            "produits"=>$products
        ]);
    }


    /**
     * Permet de voir toutes les categories
     * @param int $hopitalID
     * @return JsonResponse
    */
    public function viewAllCategories(int $hopitalID):JsonResponse
    {
        $categories = ProduitCategorie::where('hopital_id', $hopitalID)->get();
        return response()->json([
            "status"=>"success",
            "categories"=>$categories
        ]);
    }

    /**
     * Vendre le produit pharmaceutique
     * @param Request $request
     * @return JsonResponse
    */
    public function sellProduct(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'cart_datas' => 'required|array',
            ]);
            $cartDatas = $data['cart_datas'];
            DB::beginTransaction();
            foreach ($cartDatas as $item){
                $res = PharmacieOperation::create([
                    "operation_libelle"=>"vente",
                    "operation_qte"=>$item["operation_qte"],
                    "produit_id"=>$item["produit_id"],
                    "produit_prix"=>$item["produit_prix"],
                    "produit_prix_devise"=>$item["produit_devise"],
                    "pharmacie_id"=>$item["pharmacie_id"],
                    "client_id"=>$item["client_id"] ?? null,
                    "created_by"=>$item["created_by"]
                ]);
            }
            DB::commit();
            return response()->json([
                "status"=>"success",
                "message"=>"la vente effectuée avec succès !"
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
     * VOIR LES VENTES JOURNALIERES PAR PHARMACIEN
     * @param int $pharmacieID
     * @param int $userID
     * @return JsonResponse
     */
    public function viewSellingReport(int $pharmacieID, int $userID): JsonResponse
    {
        $now = Carbon::now();
        $reports = PharmacieOperation::with('user')
                                    ->with('client')
                                    ->with('produit.categorie')
                                    ->with('pharmacie')
                                    ->where('pharmacie_id', $pharmacieID)
                                    ->where('created_by', $userID)
                                    ->whereDate('operation_created_At', $now)
                                    ->whereDate('operation_libelle', 'vente')
                                    ->get();
        return response()->json([
            "reports"=>$reports
        ]);
    }
}
