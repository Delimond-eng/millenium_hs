<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;


/**
 * Un groupe des routes pour la gestion des operations hospitalières
 * Cette Gestion des operations est effectué par le corps medical!
*/

Route::middleware(['cors'])->group(function (){
    Route::post('/agents.create',[ AgentController::class,'createAgent']);
    Route::get('/agents.all/{hostoId}',[ AgentController::class,'all']);
    Route::post('/agents.assignaccount',[ AgentController::class,'assignAccount']);
    Route::post('/consultations.create',[ AgentController::class,'createConsultations']);
    Route::post('/prescriptions.add',[ AgentController::class,'addPrescriptions']);
    Route::post('/examens.add',[ AgentController::class,'addExamens']);
    Route::get('/consultations.all/{locationId}',[ AgentController::class,'viewAllConsultations']);
    Route::get('/consultations.patient/{patientId}',[ AgentController::class,'viewLastConsults']);
    Route::get('/consult.examens/{locationId}',[ AgentController::class,'allExamens']);
    Route::post('/examen.validate/{consult_id}',[ AgentController::class,'validateExamens']);
    Route::post('/prescription.validate/{consult_id}',[ AgentController::class,'validatePrescriptions']);
    Route::get('/prescription.details/{consult_id}',[ AgentController::class,'showPrescriptionDetails']);
    Route::get('/examen.detail/{consult_id}',[ AgentController::class,'showDemandExamDetails']);
    Route::get('/prescriptions.pending/{locationId}',[ AgentController::class,'allPendingPrescription']);
    Route::post('/premiersoins.create',[AgentController::class, 'administrerPremierSoins']);
    Route::get('/premiersoins.all/{locationId}',[AgentController::class, 'allPremierSoins']);

    Route::get('/code',[PatientController::class,'getCode']);
    Route::post('/patients.create',[ PatientController::class,'create']);
    Route::get('/patients.all/{locationId}',[ PatientController::class,'all']);
    Route::get('/patients.pending/{locationId}',[ PatientController::class,'viewAllPendingPatients']);
    Route::get('/patient.show/{id}',[ PatientController::class,'show']);
    Route::get('/patient.story/{patientId}',[PatientController::class, 'viewMedicalStory']);

    /**
     * Facturation & transfert
     */
    Route::post('/paiement.create', [\App\Http\Controllers\HospitalController::class, 'makePayFacture']);
    Route::post('/transfert.create', [\App\Http\Controllers\HospitalController::class, 'makePatientTransfert']);
    Route::get('/paiements.all/{emplacementId}', [\App\Http\Controllers\HospitalController::class, 'allPaiementsByEmplament']);
    Route::get('/transferts.all/{emplacementId}', [\App\Http\Controllers\HospitalController::class, 'allTransfertsByEmplament']);

});
