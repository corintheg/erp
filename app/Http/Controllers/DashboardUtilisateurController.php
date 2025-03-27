<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conge;

class DashboardUtilisateurController extends Controller
{

    public function index()
    {
        $utilisateur = auth()->user();

        $employe = $utilisateur->employe;

        if (!$employe) {
            return redirect()->back()->with('error', 'Aucun employé associé à votre compte.');
        }

        $conges = $employe->conges()->get();
        //$conges = $employe->conges();

        // Récupérer les salaires de l'employé
        $salaires = $employe->salaires()->get();

        return view('user.index', compact('conges', 'salaires'));
    }

//    public function dashboard()
//    {
//        return view('user.index');
//    }
}