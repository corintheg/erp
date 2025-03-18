<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StatistiqueStockController extends Controller
{
    public function index()
    {
        $totalProduits = Stock::sum('quantite');
        $produitsEnRupture = Stock::where('quantite', 0)->count();

        return response()->json([
            'total_produits' => $totalProduits,
            'produits_en_rupture' => $produitsEnRupture,
        ]);
    }
}
