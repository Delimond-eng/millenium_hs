<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Models\Agents;
use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['cors'])->group(function () {
    Route::post("/hospitals.create", [\App\Http\Controllers\HospitalController::class, 'createHosto']);
    Route::post("/emplacements.create", [\App\Http\Controllers\HospitalController::class, 'createEmplacement']);
    Route::get( '/emplacements.all/{hostoId}', [\App\Http\Controllers\HospitalController::class, 'viewAllEmplacements']);
    Route::post("/login",[ UserController::class, 'login']);
    Route::post("/users.store",[ UserController::class, 'store']);
    Route::get('/users.active', function () {
        $interval = Carbon::now()->subMinutes(10); // Les utilisateurs vus dans les 10 dernières minutes
        $activeUsers = User::where('last_seen', '>=', $interval)->get();
        return response()->json(['active_users' => $activeUsers]);
    });

    Route::post('/configs.services',[ ConfigController::class,'saveService']);
    Route::post('/configs.fonctions',[ ConfigController::class,'saveFonction']);
    Route::post('/configs.grades',[ ConfigController::class,'saveGrade']);
    Route::post('/configs.roles',[ ConfigController::class,'saveRole']);
    Route::post('/configs.examens',[ ConfigController::class,'saveExamenLabo']);
    Route::get('/configs.all/{hostoId}',[ ConfigController::class,'allConfigs']);
        Route::post('/configs.facturations', [ConfigController::class, 'configurerFacturation']);
    Route::get('/configs.facturations/{key}/{keyId}', [ConfigController::class, 'viewAllFacturations']);
    Route::get('/examens.all/{emplacementId}', [ConfigController::class, 'viewExamens']);

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
     * Labo module manager
    */
    Route::get('/labos.all/{hopitalId}',[\App\Http\Controllers\LaboController::class, 'allLabos']);
    Route::get('/labo.examens/{emplacementId}',[\App\Http\Controllers\LaboController::class, 'viewAllLaboExamens']);
    Route::post('/labo.create',[\App\Http\Controllers\LaboController::class, 'createLabo']);


    /**
     * Hospitalisation manage routes
    */
    Route::get('/hospitalisations.all/{emplacementId}', [\App\Http\Controllers\HospitalisationController::class, 'viewAllDatas']);
    Route::post('/lit.create', [\App\Http\Controllers\HospitalisationController::class, 'createBed']);
    Route::post('/lit.type.config', [\App\Http\Controllers\HospitalisationController::class, 'createBedType']);
    Route::post('/hospitalisation.create', [\App\Http\Controllers\HospitalisationController::class, 'createHospitalisation']);
    Route::post('/hospitalisation.make.transfert', [\App\Http\Controllers\HospitalisationController::class, 'createBedTransfert']);

    /**
     * SCHEDULE MANAGEMENT
    */
    Route::post('/schedule.create', [AgentController::class, 'createSchedule']);
    Route::get('/schedules.all/{emplacementId}', [AgentController::class, 'viewAllSchedules']);

    /**
     * Pharmacie module Routes
    */
    Route::post('/pharmacies.create', [\App\Http\Controllers\PharmacieController::class, 'createPharmacie']);
    Route::get('/pharmacies.all/{hostoId}', [\App\Http\Controllers\PharmacieController::class, 'allPharmacies']);
    Route::get('/pharmacies.emplacement/{emplacementId}', [\App\Http\Controllers\PharmacieController::class, 'viewEmplacementPharmacies']);
    Route::post('/pharmacie.create.product', [\App\Http\Controllers\PharmacieController::class, 'createProduct']);
    Route::post('/pharmacie.create.category', [\App\Http\Controllers\PharmacieController::class, 'createCategory']);


    /**
     * Facturation & transfert
    */
    Route::post('/paiement.create', [\App\Http\Controllers\HospitalController::class, 'makePayFacture']);
    Route::post('/transfert.create', [\App\Http\Controllers\HospitalController::class, 'makePatientTransfert']);
    Route::get('/paiements.all/{emplacementId}', [\App\Http\Controllers\HospitalController::class, 'allPaiementsByEmplament']);
    Route::get('/transferts.all/{emplacementId}', [\App\Http\Controllers\HospitalController::class, 'allTransfertsByEmplament']);


    /**
     * Gestion des partenaires & conventions
    */
    Route::post('/partener.create',[\App\Http\Controllers\PartenerController::class, 'createPartener']);
    Route::post('/partener.agents.import',[\App\Http\Controllers\PartenerController::class, 'importPartenerAgentFromExcel']);
    Route::get('/partener.agent.search',[\App\Http\Controllers\PartenerController::class, 'search']);
    Route::get('/parteners.all/{hopitalId}',[\App\Http\Controllers\PartenerController::class, 'viewAllParteners']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
