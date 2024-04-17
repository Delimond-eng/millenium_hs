<?php
declare(strict_types=1);

/**
 * Un Group des routes pour gérer les conventions
*/

use Illuminate\Support\Facades\Route;

Route::middleware(['cors'])->group(function () {
    Route::post('/partener.create',[\App\Http\Controllers\PartenerController::class, 'createPartener']);
    Route::post('/partener.agents.import',[\App\Http\Controllers\PartenerController::class, 'importPartenerAgentFromExcel']);
    Route::get('/partener.agent.search',[\App\Http\Controllers\PartenerController::class, 'search']);
    Route::get('/parteners.all/{hopitalId}',[\App\Http\Controllers\PartenerController::class, 'viewAllParteners']);
});
