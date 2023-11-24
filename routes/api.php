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

    Route::post("/login",[ UserController::class, 'login']);
    Route::post("/users.store",[ UserController::class, 'store']);

    Route::post('/configs.services',[ ConfigController::class,'saveService']);
    Route::post('/configs.fonctions',[ ConfigController::class,'saveFonction']);
    Route::post('/configs.grades',[ ConfigController::class,'saveGrade']);
    Route::get('/configs.all',[ ConfigController::class,'allConfigs']);


    Route::post('/agents.create',[ AgentController::class,'create']);
    Route::get('/agents.all',[ AgentController::class,'all']);
    Route::post('/agents.assignaccount',[ AgentController::class,'assignAccount']);

    Route::get('/code',[PatientController::class,'getCode']);
    Route::post('/patients.create',[ PatientController::class,'create']);
    Route::get('/patients.all',[ PatientController::class,'all']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
