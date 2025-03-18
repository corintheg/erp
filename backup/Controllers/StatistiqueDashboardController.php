<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Transaction;
use App\Models\Stock;
use App\Models\Livraison;
use App\Models\Conge;
use App\Models\Fournisseur;
use App\Models\Planning;

class StatistiqueDashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'employes' => Employe::count(),
            'revenus' => Transaction::where('type', 'revenu')->sum('montant'),
            'depenses' => Transaction::where('type', 'depense')->sum('montant'),
            'produits_stock' => Stock::sum('quantite'),
            'livraisons' => Livraison::count(),
            'conges' => Conge::count(),
            'fournisseurs' => Fournisseur::count(),
            'plannings' => Planning::count(),
        ]);
    }
}
