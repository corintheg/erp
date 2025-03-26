<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salaire;

class SalaireController extends Controller
{
    public function index()
    {
        // Récupérer tous les salaires avec les employés associés
        $salaries = Salaire::all();

        // Calcul du total des salaires
        $totalSalaries = $salaries->sum('montant');

        // Passer les données à la vue
        return view('salaries.index', compact('salaries', 'totalSalaries'));
    }

    public function create()
    {
        return view('salaries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employe_nom' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut'
        ]);

        Salaire::create($request->all());
        return redirect()->route('salaries.index')->with('success', 'Salaire ajouté avec succès.');
    }

    public function edit($id)
    {
        $salaire = Salaire::findOrFail($id);
        return view('salaries.edit', compact('salaire'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employe_nom' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut'
        ]);

        $salaire = Salaire::findOrFail($id);
        $salaire->update($request->all());

        return redirect()->route('salaries.index')->with('success', 'Salaire mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $salaire = Salaire::findOrFail($id);
        $salaire->delete();
        return redirect()->route('salaries.index')->with('success', 'Salaire supprimé avec succès.');
    }
}