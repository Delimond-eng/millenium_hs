<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * Groupe des Routes pour la Gestion des pharmacies
 */

Route::middleware(['cors'])->group(function(){
    //Route: pour créer une nouvelle pharmacie
    Route::post('/pharmacies.create', [\App\Http\Controllers\PharmacieController::class, 'createPharmacie']);
    //Route: pour voir toutes les pharmacies pour un hopital
    Route::get('/pharmacies.all/{hostoId}', [\App\Http\Controllers\PharmacieController::class, 'allPharmacies']);
    //Route: pour voir une pharmacie pour une emplacement
    Route::get('/pharmacies.emplacement/{emplacementId}', [\App\Http\Controllers\PharmacieController::class, 'viewEmplacementPharmacies']);

    //Route: pour créer un fournisseur
    Route::post('/pharmacie.create.fournisseur', [\App\Http\Controllers\PharmacieController::class, 'createFournisseur']);
    //Route: pour créer un produit pharmaceutique
    Route::post('/pharmacie.create.product', [\App\Http\Controllers\PharmacieController::class, 'createProduct']);
    Route::post('/pharmacie.product.addprices', [\App\Http\Controllers\PharmacieController::class, 'addProductPrice']);

    //Route pour créer une categorie des produits pharmaceutiques
    Route::post('/pharmacie.create.category', [\App\Http\Controllers\PharmacieController::class, 'createCategory']);
    //Route pour créer un type de produit(ex. injectable, comprimé...)
    Route::post('/pharmacie.create.type', [\App\Http\Controllers\PharmacieController::class, 'createType']);
    //Route pour créer une unité des produits pharmaceutique(ex: kg, ml...)
    Route::post('/pharmacie.create.unite', [\App\Http\Controllers\PharmacieController::class, 'createUnite']);
    //Route pour voir toutes les configurations(unites, types et categories)
    Route::get('/pharmacie.config.all/{hopitalId}', [\App\Http\Controllers\PharmacieController::class, 'allConfig']);
    //Route pour créer un nouveau stock des produits
    Route::post('/pharmacie.stock.add', [\App\Http\Controllers\PharmacieController::class, 'createStock']);
    //Route pour voir tous les les approvisionnements stock
    Route::get('/pharmacie.stocks/{pharmacieId?}', [\App\Http\Controllers\PharmacieController::class, 'viewAllStocks']);
    //Route pour afficher les infos du dernier stock du produit de la pharmacie
    Route::get('/pharmacie.stock.infos/{produitID}/{pharmacieID}', [\App\Http\Controllers\PharmacieController::class, 'viewProductStockInfos']);
    //Route pour créer une opération pharmaceutique
    Route::post('/pharmacie.operation.create', [\App\Http\Controllers\PharmacieController::class, 'saveOperation']);
    //Route pour voir les operations par status et pharmacie
    Route::get('/pharmacie.operations.all/{pharmacieID}/{key}',  [\App\Http\Controllers\PharmacieController::class, 'allOperations']);
});
