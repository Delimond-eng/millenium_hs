<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::middleware(['cors'])->group(function (){
    Route::post("/login",[ UserController::class, 'login']);
});
Route::middleware(['cors'])->group(function(){
    Route::post("/hospitals.create", [\App\Http\Controllers\HospitalController::class, 'createHosto']);
    Route::post("/emplacements.create", [\App\Http\Controllers\HospitalController::class, 'createEmplacement']);
    Route::get( '/emplacements.all/{hostoId}', [\App\Http\Controllers\HospitalController::class, 'viewAllEmplacements']);
    Route::post("/users.store",[ UserController::class, 'store']);
    Route::get('/users.active', function () {
        $interval = Carbon::now()->subMinutes(10); // Les utilisateurs vus dans les 10 dernières minutes
        $activeUsers = User::where('last_seen', '>=', $interval)->get();
        return response()->json(['active_users' => $activeUsers]);
    });
});
