<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Salaire;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    // Récupération des transactions financières
    public function index()
    {
        $transactions = Finance::all();
        return response()->json($transactions);
    }

    // Création d'une transaction
    public function store(Request $request)
    {
        $request->validate([
            'type_operation' => 'required|in:dépense,revenu,facture,taxe',
            'montant'        => 'required|numeric',
            'date_operation' => 'required|date',
        ]);

        $transaction = Finance::create($request->all());
        return response()->json([
            'message'     => 'Transaction créée avec succès',
            'transaction' => $transaction
        ], 201);
    }

    // Affichage d'une transaction spécifique
    public function show($id)
    {
        $transaction = Finance::findOrFail($id);
        return response()->json($transaction);
    }

    // Mise à jour d'une transaction
    public function update(Request $request, $id)
    {
        $transaction = Finance::findOrFail($id);
        $transaction->update($request->all());
        return response()->json([
            'message'     => 'Transaction mise à jour',
            'transaction' => $transaction
        ]);
    }

    // Suppression d'une transaction
    public function destroy($id)
    {
        $transaction = Finance::findOrFail($id);
        $transaction->delete();
        return response()->json([
            'message' => 'Transaction supprimée'
        ]);
    }
}

// Déplacer cette méthode dans un autre contrôleur (ex: SalaireController)
class SalaireController extends Controller
{
    public function index()
    {
        $salaries = Salaire::all();
        $totalSalaries = $salaries->sum('montant');

        return view('finances.index', compact('salaries', 'totalSalaries'));
    }
}
