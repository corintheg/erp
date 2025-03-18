<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $transactions = Finance::all();
        return response()->json($transactions);
    }
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

    public function show($id)
    {
        $transaction = Finance::findOrFail($id);
        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Finance::findOrFail($id);
        $transaction->update($request->all());
        return response()->json([
            'message'     => 'Transaction mise à jour',
            'transaction' => $transaction
        ]);
    }

    public function destroy($id)
    {
        $transaction = Finance::findOrFail($id);
        $transaction->delete();
        return response()->json([
            'message' => 'Transaction supprimée'
        ]);
    }
}
