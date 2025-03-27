<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\Product;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('produit')->latest()->get();
        return view('stock.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produit' => 'required|exists:products,id',
            'type' => 'required|in:Entrée,Sortie',
            'quantite' => 'required|integer|min:1',
            'commentaire' => 'nullable|string'
        ]);

        StockMovement::create($request->all());

        return redirect()->route('stock.index')->with('success', 'Mouvement ajouté avec succès.');
    }

    public function destroy(StockMovement $movement)
    {
        $movement->delete();
        return redirect()->route('stock.index')->with('success', 'Mouvement supprimé.');
    }
}
