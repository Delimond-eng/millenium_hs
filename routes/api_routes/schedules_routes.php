<?php

use App\Http\Controllers\AgentController;
use Illuminate\Support\Facades\Route;


/**
 * Un Groupe des Routes pour la gestion des rendez-vous avec les patients
*/

Route::middleware(['cors'])->group(function (){
    /**
     * SCHEDULE MANAGEMENT
     */
    Route::post('/schedule.create', [AgentController::class, 'createSchedule']);
    Route::get('/schedules.all/{emplacementId}', [AgentController::class, 'viewAllSchedules']);
});
