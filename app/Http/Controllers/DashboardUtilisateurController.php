<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conge;

class DashboardUtilisateurController extends Controller
{

    public function index()
    {
        // Récupérer l'utilisateur connecté
        $utilisateur = auth()->user();

        // Récupérer l'employé associé à cet utilisateur
        $employe = $utilisateur->employe;

        // Vérifier si l'employé existe
        if (!$employe) {
            return redirect()->back()->with('error', 'Aucun employé associé à votre compte.');
        }

        // Récupérer les congés de l'employé
        $conges = $employe->conges()->get();
//        $conges = $employe->conges();

        // Récupérer les salaires de l'employé
        $salaires = $employe->salaires()->get();

        return view('dashboard.employe', compact('conges', 'salaires'));
    }
}