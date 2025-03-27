<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salaire;

class SalaireController extends Controller
{
    public function index(Request $request)
    {
        $salaries = Salaire::with('employe')->get();
        $totalSalaries = $salaries->sum('montant');

        if ($request->ajax()) {
            return response()->json(['salaries' => $salaries, 'totalSalaries' => $totalSalaries]);
        }

        return view('salaries.index', compact('salaries', 'totalSalaries'));
    }

    public function create()
    {
        return view('salaries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_employe' => 'required|exists:employes,id',
            'montant' => 'required|numeric',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date',
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
        $salaire = Salaire::findOrFail($id);
        $salaire->update($request->all());
        return redirect()->route('salaries.index')->with('success', 'Salaire mis à jour.');
    }

    public function destroy($id)
    {
        Salaire::findOrFail($id)->delete();
        return redirect()->route('salaries.index')->with('success', 'Salaire supprimé.');
    }
}