<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use App\Models\Salaire;

class SalaireController extends Controller
{
    public function index(Request $request)
    {
        $salaries = Salaire::with('employes')->get();
        $totalSalaries = $salaries->sum('montant');

        if ($request->ajax()) {
            return response()->json(['salaires' => $salaries, 'totalSalaries' => $totalSalaries]);
        }

        return view('salaries.index', compact('salaries', 'totalSalaries'));
    }


    public function create()
    {
        // Récupérer les employés
        $employes = Employe::all();  // Nous récupérons tous les employés pour les afficher dans le formulaire
        return view('salaries.create', compact('employes'));  // Passer les employés à la vue
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_employe' => 'required|exists:employes,id_employe',
            'montant' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);
        try {
            Salaire::create([
                'id_employe' => $request->id_employe,
                'montant' => $request->montant,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'date_creation' => now(),
                'date_modification' => now(),
            ]);
            return redirect()->route('salaries.index')->with('success', 'Salaire ajouté avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'ajout du salaire.')->withInput();
        }
    }


    public function edit($id)
    {
        $salaire = Salaire::findOrFail($id);
        $employes = Employe::all();
        return view('salaries.edit', compact('salaire', 'employes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_employe' => 'required|exists:employes,id_employe',
            'montant' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        $salaire = Salaire::findOrFail($id);
        $salaire->update([
            'id_employe' => $request->id_employe,
            'montant' => $request->montant,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'date_modification' => now(),
        ]);

        return redirect()->route('salaries.index')->with('success', 'Salaire mis à jour.');
    }

    public function destroy($id)
    {
        Salaire::findOrFail($id)->delete();
        return redirect()->route('salaries.index')->with('success', 'Salaire supprimé.');
    }
}
