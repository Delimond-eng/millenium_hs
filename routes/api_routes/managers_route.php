<?php
declare(strict_types=1);

use App\Http\Controllers\AgentController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;


/**
 * Un groupe des routes pour la gestion des operations hospitalières
 * Cette Gestion des operations est effectué par le corps medical!
*/

Route::middleware(['cors'])->group(function (){
    //Create agent
    Route::post('/agents.create',[ AgentController::class,'createAgent']);
    //Voir tous les agents
    Route::get('/agents.all/{hostoId}',[ AgentController::class,'all']);
    //Assigner un compte à un agent
    Route::post('/agents.assignaccount',[ AgentController::class,'assignAccount']);

    //Creation nouvelle consultation
    Route::post('/consultations.create',[ AgentController::class,'createConsultations']);
    //Ajouter les prescriptions pour une consultation
    Route::post('/prescriptions.add',[ AgentController::class,'addPrescriptions']);
    //Ajouter les examens à une consultation
    Route::post('/examens.add',[ AgentController::class,'addExamens']);
    //Voir toutes les consultations
    Route::get('/consultations.all/{locationId}',[ AgentController::class,'viewAllConsultations']);

    //Voir le dossier medical d'un patient
    Route::get('/medical.docs/{patientId}/{hopitalId}',[ AgentController::class,'viewMedicalDocs']);
    //Voir les examens pour chaque consultation
    Route::get('/consult.examens/{locationId}',[ AgentController::class,'allExamens']);
    //Voir les examens validates
    Route::post('/examen.validate/{consult_id}',[ AgentController::class,'validateExamens']);
    //Voir les prescriptions validates
    Route::post('/prescription.validate/{consult_id}',[ AgentController::class,'validatePrescriptions']);
    //Voir les details d'une prescriptions
    Route::get('/prescription.details/{consult_id}',[ AgentController::class,'showPrescriptionDetails']);
    //Voir les details pour un examen
    Route::get('/examen.detail/{consult_id}',[ AgentController::class,'showDemandExamDetails']);
    //Voir les prescriptions en cours
    Route::get('/prescriptions.pending/{locationId}',[ AgentController::class,'allPendingPrescription']);
    //Creer les premiers soins
    Route::post('/premiersoins.create',[AgentController::class, 'administrerPremierSoins']);
    //Voir tous les premiers soins
    Route::get('/premiersoins.all/{locationId}',[AgentController::class, 'allPremierSoins']);

    //traitement d'un patient en fonction de la prescription
    Route::post('/traitements.make', [AgentController::class, 'makeTraitement']);
    Route::get('/traitements.show/{patientId}', [AgentController::class, 'showPatientTraitments']);

    //Voir la liste des traitements effectués
    Route::get('/suivis.all/{emplacementId}', [AgentController::class, 'viewAllSuivis']);

    //Renvoyer le code aleatoires
    Route::get('/code',[PatientController::class,'getCode']);
    //Creation d'un patient
    Route::post('/patients.create',[ PatientController::class,'create']);
    //Voir tous les patients
    Route::get('/patients.all/{locationId}',[ PatientController::class,'all']);
    //Voir les patients en cours
    Route::get('/patients.pending/{locationId}',[ PatientController::class,'viewAllPendingPatients']);
    //Afficher un patient
    Route::get('/patient.show/{id}',[ PatientController::class,'show']);
    //Voir le dossier medical d'un patient
    Route::get('/patient.story/{patientId}',[PatientController::class, 'viewMedicalStory']);

    /**
     * Facturation & transfert
     */

    //Creer un paiement
    Route::post('/paiement.create', [\App\Http\Controllers\HospitalController::class, 'makePayFacture']);
    //Transferer un patient
    Route::post('/transfert.create', [\App\Http\Controllers\HospitalController::class, 'makePatientTransfert']);
    //Voir tous les paiements pour un emplacement
    Route::get('/paiements.all/{id}/{key?}', [\App\Http\Controllers\FacturationPaiementController::class, 'viewAllPaiement']);
    //Voir tous les transferts pour un emplacement
    Route::get('/transferts.all/{emplacementId}', [\App\Http\Controllers\HospitalController::class, 'allTransfertsByEmplament']);

});
