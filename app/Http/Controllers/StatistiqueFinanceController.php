<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class StatistiqueFinanceController extends Controller
{
    public function index()
    {
        $revenus = Transaction::where('type', 'revenu')->sum('montant');
        $depenses = Transaction::where('type', 'depense')->sum('montant');

        return response()->json([
            'revenus' => $revenus,
            'depenses' => $depenses,
            'solde' => $revenus - $depenses,
        ]);
    }
}
