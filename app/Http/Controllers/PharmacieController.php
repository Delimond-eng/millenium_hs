<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockInfoResource;
use App\Models\Fournisseur;
use App\Models\Pharmacie;
use App\Models\PharmacieClient;
use App\Models\PharmacieOperation;
use App\Models\PharmacieTicket;
use App\Models\PharmacistSession;
use App\Models\Prescriptions;
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
     * Create new stock & compute selling price
     * @param Request $request HttpRequest data
     * @return JsonResponse
     */
    public function createStock(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'stock_qte'=>'required|integer|gt:0',
                'stock_date_exp'=>'required|date|after:now',
                'stock_pa'=>'required|numeric',
                'stock_pa_devise'=>'nullable|string',
                'marge'=>'nullable|numeric',
                'stock_pv'=>'nullable|numeric',
                'stock_obs'=>'nullable|string',
                'produit_id'=>'required|int|exists:produits,id',
                'fournisseur_id'=>'required|int|exists:fournisseurs,id',
                'pharmacie_id'=>'required|int|exists:pharmacies,id',
                'created_by'=>'required|int|exists:users,id',
            ]);
            //Cree un produit dans la base de données !
            $result = Stock::create($data);

            //voir la moyen pondered des prix d'achat
            $stockInfo = $this->viewProductStockInfos((int)$data['produit_id'], (int)$data['pharmacie_id']);
            $pu = 0;
            if (isset($data['marge']) || isset($data['stock_pv'])) {
                if (isset($data['marge'])) {
                    $pComputed = ((float)$stockInfo['stock_pa'])*(((float)$data["marge"])/100);
                     $pu = (float)$stockInfo['stock_pa'] + $pComputed;
                }
                else{
                    $pu = (float)$data["stock_pv"];
                }

            }
            else{
                    $lastProduitPrix = $priceInfos = ProduitPrice::where('produit_id',$data['produit_id'])
                        ->where('pharmacie_id',$data['pharmacie_id'])
                        ->first();
                    if (isset($lastProduitPrix)) {
                        $pu = (float)$lastProduitPrix->produit_prix;
                    }else{
                        return response()->json(['errors' => 'Vous devez entrez soit la marge bénéficiaire soit le prix de vente' ]);
                    }
                }
            //manage & calculate pu
            $price_datas = [
                "produit_prix"=> $pu,
                "pharmacie_id"=>$data['pharmacie_id'],
                "produit_id"=>$data['produit_id'],
                "hopital_id"=>$data['pharmacie_id'],
                "created_by"=>$data['created_by'],
            ];
            //Cree un produit dans la base de données !
            $priceInfos = ProduitPrice::updateOrCreate(
                [
                    'produit_id'=>$data['produit_id'],
                    'pharmacie_id'=>$data['pharmacie_id']
                ],
                $price_datas
            );
            $result['price_infos']=$priceInfos;
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
     * @param int $produitID
     * @param int $pharmacieID ;
     * @return array|null
     */
    private function viewProductStockInfos(int $produitID, int $pharmacieID): ?array
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
        return $info;
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

    /**
     * all operations by products
     * @param int $pharmacieID
     * @param string $key
    */
    public function allOperationByProduct(int $pharmacieID, Request $request):JsonResponse{
        $key = $request->query("key");
        $produitID = $request->query("id");

        $datas = [];

        if($key =='approv'){
            $datas = Stock::with('produit')
                ->with('fournisseur')
                ->with('pharmacie')
                ->with('user')
                ->where('pharmacie_id', $pharmacieID)
                ->where('produit_id', $produitID)
                ->where('stock_status', 'actif')
                ->get();
        } else {
           $datas = PharmacieOperation::with("produit.type")
            ->with('pharmacie')
            ->with('client')
            ->with('pharmacie_destination')
            ->with('fournisseur')
            ->with('user')
            ->where('operation_libelle',$key)
            ->where('pharmacie_id',$pharmacieID)
            ->where('operation_status','actif')
            ->where('produit_id',$produitID)
            ->get();
        }
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
            ->whereNot('operation_status', 'deleted')
            ->sum('operation_qte');
        //Compte la somme de stocks quantité du produit de la pharmacie
        $qteStock = Stock::with('produit')
            ->where('produit_id',$data['produit_id'] )
            ->where('pharmacie_id',$data['pharmacie_id'])
            ->whereNot('stock_status', 'deleted')
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
            ->whereNot('operation_status', 'deleted')
            ->groupBy('produit_id')
            ->get();

        $stockInfos = [];

        foreach ($stocks as $stock) {
            $qteSortie = $operations->where('produit_id', $stock->produit_id)->sum("qte_sortie") ?? 0;

            $produit = Produit::with('categorie')
                ->with('type')
                ->where('id',$stock->produit_id)->first();

            $stockInfos[] = [
                'produit'=>$produit,
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
                'client_id'=> 'nullable|int',
                'pharmacie_id'=>'required|int|exists:pharmacies,id',
                'created_by'=>'required|int|exists:users,id'
            ]);

            $cartDatas = $data['cart_datas'];

            DB::beginTransaction();
            if(!isset($data['client_id'])){
                $client = PharmacieClient::create([
                    'client_nom'=>'unknown',
                    'client_phone'=>'unknown',
                    'pharmacie_id'=>$data['pharmacie_id'],
                    'created_by'=>$data['created_by'],
                ]);
                $data['client_id']=$client->id;
            }
            //Calculate sum of tickets
            $ticketTotal =0;

            //Get Random ticket code
            $ticketCode = $this->generateRandomCode();
            foreach ($cartDatas as $item){
                $ticketTotal += (((float)$item['produit_prix']) * ((int)$item['operation_qte']));
            }
            //Create ticket before adding items
            $ticket = PharmacieTicket::create([
                "ticket_code"=>$ticketCode,
                "ticket_nb_items"=>count($cartDatas),
                "ticket_paiement"=>$ticketTotal,
                "client_id"=>$data['client_id'],
                "pharmacie_id"=>$data['pharmacie_id'],
                "user_id"=>$data['created_by'],
            ]);

            if(isset($ticket)){
                foreach ($cartDatas as $item){
                    $res = PharmacieOperation::create([
                        "operation_libelle"=>"Vente",
                        "operation_qte"=>$item["operation_qte"],
                        "produit_id"=>$item["produit_id"],
                        "produit_prix"=>$item["produit_prix"],
                        "produit_prix_devise"=>$item["produit_devise"],
                        "pharmacie_id"=>$item["pharmacie_id"],
                        "client_id"=>$data['client_id'],
                        "ticket_id"=>$ticket->id,
                        "created_by"=>$item["created_by"]
                    ]);
                }
                $invoice = PharmacieTicket::with(["items"=> function ($query){
                    return $query->whereNot("operation_status", "deleted");
                },"items.produit.categorie","items.produit.type","items.pharmacie", "items.client", "items.user"])
                    ->with('user')
                    ->with('client')
                    ->with('pharmacie')
                    ->whereNot('ticket_status', 'deleted')
                    ->where('id', $ticket->id)->first();
                DB::commit();
                return response()->json([
                    "status"=>"success",
                    "invoice"=>$invoice,
                    "message"=>"la vente effectuée avec succès !"
                ]);
            }
            else{
                return response()->json(['errors' => "Echec du traitement des informations" ]);
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
     * Generate Random alphanumeric code
     * @return string
    */
    private function generateRandomCode(): string
    {
        $lettreAleatoire = chr(rand(65, 90));
        $chiffresAleatoires = str_pad(rand(0, 9999), 5, '0', STR_PAD_LEFT);
        return $lettreAleatoire . $chiffresAleatoires;
    }


    /**
     * VOIR LES VENTES JOURNALIERES PAR PHARMACIEN
     * @param Request $request
     * @param int $pharmacieID
     * @param int $userID
     * @return JsonResponse
     */
    public function viewSellingReport(Request $request, int $pharmacieID, int $userID): JsonResponse
    {
        $now = Carbon::now();
        $role = $request->query('role');
        if(!isset($role)){
            // Retrieve all relevant data in one database query
            $reports = PharmacieTicket::with(["items"=> function ($query){
                return $query->whereNot("operation_status", "deleted");
            },"items.produit.categorie","items.produit.type","items.pharmacie", "items.client", "items.user"])
                ->with('user')
                ->with('client')
                ->with('pharmacie')
                ->whereDate('created_at', $now)
                ->where('pharmacie_id', $pharmacieID)
                ->where('user_id', $userID)
                ->whereNot('ticket_status', 'deleted')
                ->get();

            // Get client count
            $clientCount = PharmacieClient::whereDate('client_created_At', $now)
                ->where('pharmacie_id', $pharmacieID)
                ->where('created_by', $userID)
                ->count();

            $ticketCount = PharmacieTicket::whereDate('created_at', $now)
                ->where('pharmacie_id', $pharmacieID)
                ->where('user_id', $userID)
                ->whereNot('ticket_status','deleted')
                ->count();

            // Calculate quantity sells and day balance
            $qtySells = PharmacieOperation::where('pharmacie_id', $pharmacieID)
                ->where('created_by', $userID)
                ->whereDate('operation_created_At', $now)
                ->whereNot('operation_status', 'deleted')
                ->sum('operation_qte');


            $dayBalance = 0;
            $abortSells = PharmacieTicket::where('pharmacie_id', $pharmacieID)
                ->where('user_id', $userID)
                ->whereDate('created_at', $now)->where('ticket_status', 'deleted')->count();
        }
        else{

            $reports = PharmacieTicket::with(["items"=> function ($query){
                return $query->whereNot("operation_status", "deleted");
            },"items.produit.categorie","items.produit.type","items.pharmacie", "items.client", "items.user"])
                ->with('user')
                ->with('client')
                ->with('pharmacie')
                ->whereDate('created_at', $now)
                ->where('pharmacie_id', $pharmacieID)
                ->whereNot('ticket_status', 'deleted')
                ->get();

            // Get client count
            $clientCount = PharmacieClient::whereDate('client_created_At', $now)
                ->where('pharmacie_id', $pharmacieID)
                ->count();

            $ticketCount = PharmacieTicket::whereDate('created_at', $now)
                ->where('pharmacie_id', $pharmacieID)
                ->whereNot('ticket_status', 'deleted')
                ->count();

            // Calculate quantity sells and day balance
            $qtySells = PharmacieOperation::where('pharmacie_id', $pharmacieID)
                    ->whereDate('operation_created_At', $now)
                    ->whereNot('operation_status', 'deleted')
                    ->sum('operation_qte');
            $dayBalance = 0;
            $abortSells = PharmacieTicket::where('pharmacie_id', $pharmacieID)
                ->whereDate('created_at', $now)->where('ticket_status', 'deleted')->count();
            // Count aborted sells


        }
        foreach ($reports as $report) {
            $dayBalance += (float)$report->ticket_paiement;
        }
        return response()->json([
            "grids" => $reports,
            "counts" => [
                "clients" => $clientCount,
                "qty_sells" => $qtySells,
                "abort_sells" => $abortSells,
                "balance" => $dayBalance,
                "tickets" => $ticketCount
            ]
        ]);


    }


    /**
     * Delete or abort operation
     * @param int $id
     * @param string|null $table
     * @return JsonResponse
     */
    public function deleteSelling(int $id, string $table=null):JsonResponse
    {
        if(!isset($table)){
            $result = PharmacieTicket::find($id);
            $result->ticket_status = 'deleted';
            $result->save();
            PharmacieOperation::where('ticket_id',$result->id)->update(["operation_status"=>"deleted"]);
            return response()->json([
                "status"=>"success",
                "result"=>$result
            ]);
        }
        else{
            $operation = PharmacieOperation::find($id);
            $operation->operation_status = "deleted";
            $operation->save();
            $result = PharmacieTicket::find($operation->ticket_id);
            $result->ticket_nb_items = $result->ticket_nb_items - 1;
            $result->save();
            return response()->json([
                "status"=>"success",
                "result"=>$operation
            ]);
        }
    }

    /**
     * Start day session
     * @param Request $request
     * @return JsonResponse
     */
    public function startPharmacistSession(Request $request):JsonResponse
    {
        $now = Carbon::now()->format('H:i:s');
        try {
            $data = $request->validate([
                'initial_balance'=>'required|numeric',
                'user_id'=>'required|int|exists:users,id',
                'pharmacie_id'=>'required|int|exists:pharmacies,id',
            ]);

            $session = PharmacistSession::create([
                "initial_balance"=>$data["initial_balance"],
                "user_id"=>$data["user_id"],
                "pharmacie_id"=>$data["pharmacie_id"],
                "started_at"=>$now,
            ]);

            return response()->json([
                "status"=>"success",
                "task"=>"start",
                "session"=>$session
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
     * Start day session
     * @param Request $request
     * @return JsonResponse
     */
    public function sendPharmacistSession(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'id'=>'required|int|exists:pharmacist_sessions,id',
                'closing_balance'=>'required|numeric',
                'nbre_ticket'=>'required|int',
            ]);
            $now = Carbon::now()->format('H:i:s');
            $lastSession = PharmacistSession::find($data['id']);
            $lastSession->nbre_ticket = $data['nbre_ticket'];
            $lastSession->closing_balance = $data['closing_balance'];
            $lastSession->end_at = $now;
            $lastSession->save();
            return response()->json([
                "status"=>"success",
                "task"=>"end",
                "session"=>$lastSession
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
     * receive medical prescription
     * @param string $code
    */
    public function receivePrescription(string $code): JsonResponse{
        $prescription = Prescriptions::with('produit.type')->with('produit.categorie')->where('prescription_code', $code)->get();
        return response()->json([
            "status"=>"success",
            "prescriptions"=>$prescription
        ]);
    }


}