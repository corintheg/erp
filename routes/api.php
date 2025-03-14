<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalaireController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\FinanceController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('salaires', SalaireController::class);
    Route::apiResource('conges', CongeController::class);
    Route::apiResource('absences', AbsenceController::class);
    Route::apiResource('transactions', FinanceController::class);
});
