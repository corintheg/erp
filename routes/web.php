<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeController;



Route::get('/', [LoginController::class, 'showLoginForm'])->name(name: 'login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



//GESTION DES ENMPLOYÉ
// Route pour afficher le formulaire (GET)
Route::get('/add_employe', function () {
    return view('auth.add_employe');
});

// Route pour enregistrer un employé
Route::post('/add_employe', [EmployeController::class, 'add_employe']);


//GESTION DES DEMANDE DE CONGÉ
Route::get('/leave_request', function () {
    return view('leave_request');
});
>>>>>>> routes/web.php
