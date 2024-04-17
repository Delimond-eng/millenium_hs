<?php


use App\Http\Controllers\ConfigController;
use Illuminate\Support\Facades\Route;

Route::middleware(['cors'])->group(function(){
    Route::post('/configs.services',[ ConfigController::class,'saveService']);
    Route::post('/configs.fonctions',[ ConfigController::class,'saveFonction']);
    Route::post('/configs.grades',[ ConfigController::class,'saveGrade']);
    Route::post('/configs.roles',[ ConfigController::class,'saveRole']);
    Route::post('/configs.examens',[ ConfigController::class,'saveExamenLabo']);
    Route::get('/configs.all/{hostoId}',[ ConfigController::class,'allConfigs']);
    Route::post('/configs.facturations', [ConfigController::class, 'configurerFacturation']);
    Route::get('/configs.facturations/{key}/{keyId}', [ConfigController::class, 'viewAllFacturations']);
    Route::get('/examens.all/{emplacementId}', [ConfigController::class, 'viewExamens']);
});
