<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Models\Agents;
use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

    Route::post('/configs.services',[ ConfigController::class,'saveService']);
    Route::post('/configs.fonctions',[ ConfigController::class,'saveFonction']);
    Route::post('/configs.grades',[ ConfigController::class,'saveGrade']);
    Route::post('/configs.roles',[ ConfigController::class,'saveRole']);
    Route::get('/configs.all/{hostoId}',[ ConfigController::class,'allConfigs']);

    Route::post('/agents.create',[ AgentController::class,'create']);
    Route::get('/agents.all/{hostoId}',[ AgentController::class,'all']);
    Route::post('/agents.assignaccount',[ AgentController::class,'assignAccount']);
    Route::get('/agents.showassigns/{emplacementId}/{agentId}',[ AgentController::class,'showPendingPatient']);

    Route::post('/consultations.create',[ AgentController::class,'createConsultations']);
    Route::post('/prescriptions.add',[ AgentController::class,'addPrescriptions']);
    Route::get('/consultations.all/{hostoId}/{locationId}',[ AgentController::class,'viewAllConsultations']);

    Route::get('/code',[PatientController::class,'getCode']);
    Route::post('/patients.create',[ PatientController::class,'create']);
    Route::get('/patients.all/{locationId}',[ PatientController::class,'all']);
    Route::get('/patient.show/{id}',[ PatientController::class,'show']);
    Route::post('/patients.assign',[ PatientController::class,'assign']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
