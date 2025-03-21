<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CongeController;


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