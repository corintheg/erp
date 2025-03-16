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


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function () {
        return response()->json(auth()->user());
    });
});

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FinanceController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->middleware('role:admin');
    Route::get('/transactions', [FinanceController::class, 'index'])->middleware('role:manager');
});