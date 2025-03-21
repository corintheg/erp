<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CongeController;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Controllers\AdminController;




Route::middleware('guest')->group(function () { // Vérifie si l'utilisateur est connecté
    Route::get('/', [LoginController::class, 'showLoginForm'])->name(name: 'login');
    Route::post('/', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () { // Vérifie si l'utilisateur n'est pas connecté
    Route::get('/dashboard', function () {
        return view('/dashboard/index');
    });
    //GESTION DES EMPLOYÉS
    // Route pour afficher le formulaire (GET)
    Route::get('/add_employe', [EmployeController::class, 'view_add_employe'])
        ->middleware(PermissionMiddleware::class . ':admin');

    // Route pour enregistrer un employé
    Route::post('/add_employe', [EmployeController::class, 'add_employe']);


    //GESTION DES DEMANDE DE CONGÉ
    Route::get('/leave_request', [CongeController::class, 'view_leave_request']);
    Route::post('/leave_request', [CongeController::class, 'leave_request']);

    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')
        ->middleware('permission:superadmin');


});

