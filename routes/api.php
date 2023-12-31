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
    Route::get('/examens.all/{emplacementId}', [ConfigController::class, 'viewExamens']);

    Route::post('/agents.create',[ AgentController::class,'create']);
    Route::get('/agents.all/{hostoId}',[ AgentController::class,'all']);
    Route::post('/agents.assignaccount',[ AgentController::class,'assignAccount']);
    Route::post('/consultations.create',[ AgentController::class,'createConsultations']);
    Route::post('/prescriptions.add',[ AgentController::class,'addPrescriptions']);
    Route::post('/examens.add',[ AgentController::class,'addExamens']);
    Route::get('/consultations.all/{hostoId}/{locationId}',[ AgentController::class,'viewAllConsultations']);
    Route::get('/consultations.patient/{patientId}',[ AgentController::class,'viewLastConsults']);
    Route::get('/consult.examens/{locationId}',[ AgentController::class,'allExamens']);
    Route::post('/examen.validate/{consult_id}',[ AgentController::class,'validateExamens']);
    Route::post('/prescription.validate/{consult_id}',[ AgentController::class,'validatePrescriptions']);
    Route::get('/prescription.details/{consult_id}',[ AgentController::class,'showPrescriptionDetails']);
    Route::get('/examen.detail/{consult_id}',[ AgentController::class,'showDemandExamDetails']);
    Route::get('/prescriptions.pending/{locationId}',[ AgentController::class,'allPendingPrescription']);

    Route::get('/code',[PatientController::class,'getCode']);
    Route::post('/patients.create',[ PatientController::class,'create']);
    Route::get('/patients.all/{locationId}',[ PatientController::class,'all']);
    Route::get('/patients.pending/{locationId}',[ PatientController::class,'viewAllPendingPatients']);
    Route::get('/patient.show/{id}',[ PatientController::class,'show']);
    /**
     * Labo module manager
    */
    Route::get('/labos.all/{hopitalId}',[\App\Http\Controllers\LaboController::class, 'allLabos']);
    Route::get('/labo.examens/{emplacementId}',[\App\Http\Controllers\LaboController::class, 'viewAllLaboExamens']);
    Route::post('/labo.create',[\App\Http\Controllers\LaboController::class, 'createLabo']);

    /**
     * Pharmacie module Routes
    */

    Route::post('/pharmacies.create', [\App\Http\Controllers\PharmacieController::class, 'createPharmacie']);
    Route::get('/pharmacies.all/{hostoId}', [\App\Http\Controllers\PharmacieController::class, 'allPharmacies']);
    Route::get('/pharmacies.emplacement/{emplacementId}', [\App\Http\Controllers\PharmacieController::class, 'viewEmplacementPharmacies']);
    Route::post('/pharmacie.create.product', [\App\Http\Controllers\PharmacieController::class, 'createProduct']);
    Route::post('/pharmacie.create.category', [\App\Http\Controllers\PharmacieController::class, 'createCategory']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
