<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ici, vous pouvez assumer que l'utilisateur est bien "admin"
        // car le middleware a déjà fait la vérification.
        return view('admin.dashboard');
    }
}
