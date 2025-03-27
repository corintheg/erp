<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conge;
use App\Models\Employe;

class DashboardUtilisateurController extends Controller
{

    public function index()
    {
        $utilisateur = auth()->user();

        $employe = $utilisateur->employe;

        if ($utilisateur->id_employee == null) {
            return redirect()->back()->with('error', "Votre compte n'est pas lié à un employé");

        }

        $conges = $employe->conges()->get();
        //        $conges = $employe->conges();

        // Récupérer les salaires de l'employé
        $salaires = $employe->salaires()->get();

        return view('user.index', compact('conges', 'salaires'));
    }

    //    public function dashboard()
//    {
//        return view('user.index');
//    }
}