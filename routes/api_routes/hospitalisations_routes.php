<?php

use Illuminate\Support\Facades\Route;


/**
 * Groupe des routes dediés à la Gestion des hospitalisations(lit, paiement et autre)
*/
Route::middleware(['cors'])->group(function (){
    /**
     * Hospitalisation manage routes
     */
    Route::get('/hospitalisations.all/{emplacementId}', [\App\Http\Controllers\HospitalisationController::class, 'viewAllDatas']);
    Route::post('/lit.create', [\App\Http\Controllers\HospitalisationController::class, 'createBed']);
    Route::post('/lit.type.config', [\App\Http\Controllers\HospitalisationController::class, 'createBedType']);
    Route::post('/hospitalisation.create', [\App\Http\Controllers\HospitalisationController::class, 'createHospitalisation']);
    Route::post('/hospitalisation.make.transfert', [\App\Http\Controllers\HospitalisationController::class, 'createBedTransfert']);
});
