<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeController;

// Page d'accueil (connexion)
Route::get('/', function () {
    return view('auth.login');
});

// Route pour afficher le formulaire (GET)
Route::get('/add_employe', function () {
    return view('auth.add_employe'); // Assure-toi que tu as une vue add_employe.blade.php
});

// Route pour enregistrer un employé
Route::post('/add_employe', [EmployeController::class, 'add_employe']);
