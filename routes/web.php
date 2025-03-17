<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeController;

// Page d'accueil (connexion)
Route::get('/', function () {
    return view('auth.login');
});

// Route pour afficher le formulaire (GET)
Route::get('/register', function () {
    return view('auth.register'); // Assure-toi que tu as une vue register.blade.php
});

// Route pour enregistrer un employé
Route::post('/register', [EmployeController::class, 'register']);
