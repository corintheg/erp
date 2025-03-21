<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salaire; // Modèle Salaire
use App\Models\Employe; // Modèle Employe (assumé)
use Illuminate\Support\Facades\DB;

class SalaireController extends Controller
{
    /**
     * Affiche la page principale des salaires avec la liste et les données des graphiques
     */
    public function index()
    {
        // Récupérer tous les salaires avec les informations des employés
        $salaries = Salaire::join('employes', 'salaires.id_employe', '=', 'employes.id')
            ->select('salaires.*', 'employes.nom as employe_nom')
            ->get();

        // Données pour le graphique "Répartition des Salaires"
        $salaryDistribution = Salaire::join('employes', 'salaires.id_employe', '=', 'employes.id')
            ->whereNull('salaires.date_fin') // Salaires actuels
            ->select('employes.nom as employe_nom', 'salaires.montant')
            ->get()
            ->map(function ($salaire) {
                return [
                    'nom' => $salaire->employe_nom,
                    'montant' => $salaire->montant,
                ];
            });

        // Données pour le graphique "Évolution des Salaires"
        $salaryEvolution = Salaire::join('employes', 'salaires.id_employe', '=', 'employes.id')
            ->select('employes.nom as employe_nom', 'salaires.montant', 'salaires.date_debut')
            ->orderBy('salaires.date_debut', 'asc')
            ->get()
            ->groupBy('employe_nom')
            ->map(function ($group) {
                return [
                    'nom' => $group->first()->employe_nom,
                    'data' => $group->map(function ($salaire) {
                        return [
                            'montant' => $salaire->montant,
                            'date_debut' => $salaire->date_debut->format('Y-m'),
                        ];
                    })->all(),
                ];
            });

        // Total des salaires actuels
        $totalSalaries = Salaire::whereNull('date_fin')->sum('montant');

        return view('finance.salaries.index', compact('salaries', 'salaryDistribution', 'salaryEvolution', 'totalSalaries'));
    }

    /**
     * Affiche le formulaire pour ajouter un nouveau salaire
     */
    public function create()
    {
        $employes = Employe::all(); // Liste des employés pour le formulaire
        return view('finance.salaries.create', compact('employes'));
    }

    /**
     * Enregistre un nouveau salaire
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_employe' => 'required|exists:employes,id',
            'montant' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after:date_debut',
        ]);

        Salaire::create([
            'id_employe' => $request->id_employe,
            'montant' => $request->montant,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        return redirect()->route('salaries.index')->with('success', 'Salaire ajouté avec succès.');
    }

    /**
     * Affiche le formulaire pour éditer un salaire
     */
    public function edit($id)
    {
        $salaire = Salaire::findOrFail($id);
        $employes = Employe::all();
        return view('finance.salaries.edit', compact('salaire', 'employes'));
    }

    /**
     * Met à jour un salaire existant
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_employe' => 'required|exists:employes,id',
            'montant' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after:date_debut',
        ]);

        $salaire = Salaire::findOrFail($id);
        $salaire->update([
            'id_employe' => $request->id_employe,
            'montant' => $request->montant,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        return redirect()->route('salaries.index')->with('success', 'Salaire mis à jour avec succès.');
    }

    /**
     * Supprime un salaire
     */
    public function destroy($id)
    {
        $salaire = Salaire::findOrFail($id);
        $salaire->delete();

        return redirect()->route('salaries.index')->with('success', 'Salaire supprimé avec succès.');
    }
}