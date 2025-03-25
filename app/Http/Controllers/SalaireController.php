<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salaire;

class SalaireController extends Controller
{
    public function index()
    {
        $salaries = Salaire::with('employe')->get();
        $totalSalaries = $salaries->sum('montant');

        $salaryDistribution = $salaries->map(function ($salaire) {
            return [
                'nom' => $salaire->employe ? $salaire->employe->nom : 'Inconnu',
                'montant' => $salaire->montant,
            ];
        });

        $salaryEvolution = $salaries->groupBy(function ($salaire) {
            return $salaire->date_debut->format('Y-m');
        })->map(function ($group) {
            return [
                'nom' => $group->first()->employe ? $group->first()->employe->nom : 'Inconnu',
                'data' => $group->pluck('montant')->all(),
            ];
        });

        return view('finance', compact('salaries', 'totalSalaries', 'salaryDistribution', 'salaryEvolution'));
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