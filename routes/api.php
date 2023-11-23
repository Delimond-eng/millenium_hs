<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\UserController;
use App\Models\Agents;
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

    Route::post('/services.create',[ ConfigController::class,'saveService']);
    Route::get('/services.all',[ ConfigController::class,'allServices']);

    Route::post('/fonctions.create',[ ConfigController::class,'saveFonction']);
    Route::get('/fonctions.all',[ ConfigController::class,'allFonctions']);

    Route::post('/grades.create',[ ConfigController::class,'saveGrade']);
    Route::get('/grades.all',[ ConfigController::class,'allGrades']);

    Route::post('/agents.create',[ AgentController::class,'create']);
    Route::get('/agents.all',[ AgentController::class,'all']);
    Route::post('/agents.assignaccount',[ AgentController::class,'assignAccount']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});