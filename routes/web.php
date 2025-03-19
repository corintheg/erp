<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

use App\Http\Controllers\TestDatabaseController;

Route::get('/test-database', [TestDatabaseController::class, 'index']);
