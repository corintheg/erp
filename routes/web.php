<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CongeController;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalaireController;

Route::get('/salaries', [SalaireController::class, 'index'])->name('salaries.index');



Route::get('/finance/salaries', [SalaireController::class, 'index'])->name('salaries.index');
Route::get('/finance/salaries/add', [SalaireController::class, 'create'])->name('salaries.create');
Route::post('/finance/salaries', [SalaireController::class, 'store'])->name('salaries.store');
Route::get('/finance/salaries/edit/{id}', [SalaireController::class, 'edit'])->name('salaries.edit');
Route::put('/finance/salaries/{id}', [SalaireController::class, 'update'])->name('salaries.update');
Route::delete('/finance/salaries/{id}', [SalaireController::class, 'destroy'])->name('salaries.delete');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/inventory', fn() => view('inventory'))->name('inventory');
    Route::get('/hr', fn() => view('hr'))->name('hr');
    Route::resource('/finance/salaries', SalaireController::class)->names('salaries');
    Route::get('/settings', fn() => view('settings'))->name('settings');
    Route::post('/logout', fn() => auth()->logout())->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name(name: 'login');
    Route::post('/', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('/dashboard/index');




    });


    //GESTION DES EMPLOYÉS


    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');


    //GESTION DES ENMPLOYÉ
    // Route pour afficher le formulaire (GET)
    Route::get('/add_employe', [EmployeController::class, 'create']);
    Route::post('/add_employe', [EmployeController::class, 'add_employe'])->name('add_employe');
    Route::get('/employes', [EmployeController::class, 'index'])->name('employes.index');
    Route::put('/employes/{id}', [EmployeController::class, 'update'])->name('employes.update');


    //GESTION DES DEMANDE DE CONGÉ
    Route::get('/leave_approval', [CongeController::class, 'approval'])->name('leave.approval');
    Route::post('/leave_approve/{id}', [CongeController::class, 'approveLeave'])->name('leave.approve');
    Route::post('/leave_reject/{id}', [CongeController::class, 'rejectLeave'])->name('leave.reject');
    Route::get('/leave_request', [CongeController::class, 'view_leave_request'])->name('leave.request');
    Route::post('/leave_request', [CongeController::class, 'leave_request'])->name('leave.request.store');
});
Route::get('/finance', function () {
    return view('finance');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/finance', function () {
        return view('/finance');




    });});
