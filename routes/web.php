<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CongeController;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalaireController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardUtilisateurController;

Route::get('/salaries', [SalaireController::class, 'index'])->name('salaries.index');

Route::get('/finance/salaries', [SalaireController::class, 'index'])->name('salaries.index');
Route::get('/finance/salaries/add', [SalaireController::class, 'create'])->name('salaries.create');
Route::post('/finance/salaries', [SalaireController::class, 'store'])->name('salaries.store');
Route::get('/finance/salaries/edit/{id}', [SalaireController::class, 'edit'])->name('salaries.edit');
Route::put('/finance/salaries/{id}', [SalaireController::class, 'update'])->name('salaries.update');
Route::delete('/finance/salaries/{id}', [SalaireController::class, 'destroy'])->name('salaries.delete');

Route::middleware('auth')->group(function () {
    Route::get('/inventory', fn() => view('inventory'))->name('inventory');
    Route::get('/hr', fn() => view('hr'))->name('hr');
    Route::resource('/finance/salaries', SalaireController::class)->names('salaries');
    Route::get('/settings', fn() => view('settings'))->name('settings');
});
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name(name: 'login');
    Route::post('/', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::middleware(PermissionMiddleware::class . ':superadmin,admin')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/', [AdminController::class, 'dashboard'])->name('admin.index');
            Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
            Route::post('/', [AdminController::class, 'store'])->name('admin.store');
            Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
            Route::put('/{id}', [AdminController::class, 'update'])->name('admin.update');
            Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
        });

    });

    //GESTION DES DEMANDE DE CONGÉS
    Route::get('/employes', [EmployeController::class, 'index'])->name('employes.index');
    //GESTION DES DEMANDE DE CONGÉ
    Route::get('/leave_approval', [CongeController::class, 'approval'])->name('leave.approval');
    Route::post('/leave_approve/{id}', [CongeController::class, 'approveLeave'])->name('leave.approve');
    Route::post('/leave_reject/{id}', [CongeController::class, 'rejectLeave'])->name('leave.reject');
    Route::get('/leave_request', [CongeController::class, 'view_leave_request'])->name('leave.request');
    Route::post('/leave_request', [CongeController::class, 'leave_request'])->name('leave.request.store');


    Route::middleware(PermissionMiddleware::class . ':superadmin,admin,manager,rh')->group(function () {
        // GESTION DES EMPLOYÉS
        Route::get('/employes', [EmployeController::class, 'index'])->name('employes.index');
        Route::get('/employes/create', [EmployeController::class, 'create'])->name('employes.create');
        Route::post('/employes', [EmployeController::class, 'store'])->name('employes.store');
        Route::get('/employes/{id}/edit', [EmployeController::class, 'edit'])->name('employes.edit');
        Route::put('/employes/{id}', [EmployeController::class, 'update'])->name('employes.update');
    });
    Route::middleware(PermissionMiddleware::class . ':superadmin,admin,manager,finance,livreur')->group(function () {
        Route::put('fournisseurs/{fournisseur}', [FournisseurController::class, 'update'])->name('fournisseurs.update');
        Route::delete('fournisseurs/{fournisseur}', [FournisseurController::class, 'destroy'])->name('fournisseurs.destroy');
        Route::get('fournisseurs', [FournisseurController::class, 'index'])->name('fournisseurs.index');
        Route::get('fournisseurs/create', [FournisseurController::class, 'create'])->name('fournisseurs.create');
        Route::post('fournisseurs', [FournisseurController::class, 'store'])->name('fournisseurs.store');
        Route::get('fournisseurs/{fournisseur}/edit', [FournisseurController::class, 'edit'])->name('fournisseurs.edit');

    });

});




Route::get('/dashboard/user', [DashboardUtilisateurController::class, 'index'])->name('dashboard')->middleware('auth');