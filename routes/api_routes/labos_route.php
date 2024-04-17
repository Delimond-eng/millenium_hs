<?php

use Illuminate\Support\Facades\Route;

/**
 * Labo module manager
 * Un Group de Routes dedié à la Gestion des operations laboratoires
 */
Route::middleware(['cors'])->group(function(){

    Route::post('/labo.create',[\App\Http\Controllers\LaboController::class, 'createLabo']);
    Route::get('/labos.all/{hopitalId}',[\App\Http\Controllers\LaboController::class, 'allLabos']);
    Route::get('/labo.examens/{emplacementId}',[\App\Http\Controllers\LaboController::class, 'viewAllLaboExamens']);

});
