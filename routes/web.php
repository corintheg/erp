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
use App\Http\Controllers\StockMovementController;

Route::get('/stocks', [StockMovementController::class, 'index'])->name('stock.index');
Route::get('/stocks/create', [StockMovementController::class, 'create'])->name('stock.create');
Route::post('/stocks', [StockMovementController::class, 'store'])->name('stock.store');
Route::delete('/stocks/{movement}', [StockMovementController::class, 'destroy'])->name('stock.destroy');

use App\Http\Controllers\DashboardUtilisateurController;

Route::get('/salaries', [SalaireController::class, 'index'])->name('salaries.index');
Route::get('/salaries', [SalaireController::class, 'index'])->name('salaries.index');
Route::get('/salaries/create', [SalaireController::class, 'create'])->name('salaries.create');
Route::post('/salaries', [SalaireController::class, 'store'])->name('salaries.store');
Route::get('/salaries/{id}/edit', [SalaireController::class, 'edit'])->name('salaries.edit');
Route::put('/salaries/{id}', [SalaireController::class, 'update'])->name('salaries.update');
Route::delete('/salaries/{id}', [SalaireController::class, 'destroy'])->name('salaries.delete');


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


    // DASHBOARD

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/user/dashboard', [DashboardUtilisateurController::class, 'index'])->name('user.dashboard');
    Route::post('/user/dashboard', [DashboardUtilisateurController::class, 'dashboard'])->name('user.dashboard');
    // FINANCES

    Route::middleware(PermissionMiddleware::class . ':superadmin,admin,finance')->group(function () {
        Route::prefix('finance')->group(function () {
            Route::get('/', [SalaireController::class, 'index'])->name('finance.index');
            Route::get('/salaries', [SalaireController::class, 'index'])->name('finance.salaries');
            Route::get('/salaries/create', [SalaireController::class, 'create'])->name('finance.salaries.create');
            Route::post('/salaries', [SalaireController::class, 'store'])->name('finance.salaries.store');
            Route::get('/salaries/{id}/edit', [SalaireController::class, 'edit'])->name('finance.salaries.edit');
            Route::put('/salaries/{id}', [SalaireController::class, 'update'])->name('finance.salaries.update');
            Route::delete('/salaries/{id}', [SalaireController::class, 'destroy'])->name('finance.salaries.destroy');
        });
    });

    // ADMIN

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


    Route::get('/employes', [EmployeController::class, 'index'])->name('employes.index');
    //GESTION DES DEMANDE DE CONGÉ
    Route::get('/conges', [CongeController::class, 'approval'])->name('conges.index');
    Route::post('/conges/{id}', [CongeController::class, 'approveLeave'])->name('conges.approve');
    Route::post('/leave_reject/{id}', [CongeController::class, 'rejectLeave'])->name('conges.reject');
    Route::get('/conges/create', [CongeController::class, 'view_leave_request'])->name('conges.create');
    Route::post('/conges/create', [CongeController::class, 'leave_request'])->name('conges.create.store');

    // GESTION EMPLOYES

    Route::middleware(PermissionMiddleware::class . ':superadmin,admin,manager,rh')->group(function () {
        Route::prefix('employes')->group(function () {
            Route::get('/', [EmployeController::class, 'index'])->name('employes.index');
            Route::get('/create', [EmployeController::class, 'create'])->name('employes.create');
            Route::post('/', [EmployeController::class, 'store'])->name('employes.store');
            Route::get('/{id}/edit', [EmployeController::class, 'edit'])->name('employes.edit');
            Route::put('/{id}', [EmployeController::class, 'update'])->name('employes.update');
            Route::delete('/{id}', [EmployeController::class, 'destroy'])->name('employes.destroy');
        });
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

Route::get('/inventory', function () {
    $items = ['item1', 'item2', 'item3']; // Exemple de données
    return view('inventory', ['items' => $items]);
});
use App\Http\Controllers\InventoryController;

Route::get('/inventory', [InventoryController::class, 'index']);

Route::get('/dashboard/user', [DashboardUtilisateurController::class, 'index'])->name('dashboard.user')->middleware('auth');