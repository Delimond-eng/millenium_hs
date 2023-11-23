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
    Route::post("/user",[ UserController::class, 'store']);

    Route::post('/service',[ ConfigController::class,'saveService']);
    Route::get('/services',[ ConfigController::class,'allServices']);

    Route::post('/fonction',[ ConfigController::class,'saveFonction']);
    Route::get('/fonctions',[ ConfigController::class,'allFonctions']);

    Route::post('/grade',[ ConfigController::class,'saveGrade']);
    Route::get('/grades',[ ConfigController::class,'allGrades']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});