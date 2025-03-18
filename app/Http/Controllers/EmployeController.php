<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe; // Assure-toi d'importer le modèle si nécessaire

class EmployeController extends Controller
{
    public function add_employe(Request $request)
    {
        $employe = new Employe();
        $employe->nom = $request->nom;
        $employe->prenom = $request->prenom;
        $employe->email = $request->email;
        $employe->telephone = $request->telephone;
        $employe->date_embauche = $request->date_embauche;
        $employe->departement = $request->departement;
        $employe->save();
        return response()->json(['message' => 'Employé enregistré avec succès !']);
    }
}
