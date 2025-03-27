<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 📌 Statistiques des employés (Regroupement par rôle)
        $employeeStats = DB::table('roles')
            ->join('utilisateurs', 'roles.id_role', '=', 'id_role')
            ->select('roles.nom_role', DB::raw('COUNT(roles.id_role) as total'))
            ->groupBy('roles.nom_role')
            ->get();


        // 📌 Statistiques financières (Revenus & Dépenses)
        $financeStats = DB::table('finances')
            ->select(
                DB::raw("SUM(CASE WHEN type_operation = 'revenu' THEN montant ELSE 0 END) as revenus"),
                DB::raw("SUM(CASE WHEN type_operation = 'depense' THEN montant ELSE 0 END) as depenses")
            )
            ->first();

        // 📌 Statistiques des stocks
        $stockStats = DB::table('stocks')
            ->select('nom_produit', 'quantite')
            ->get();

        return view('dashboard', compact('employeeStats', 'financeStats', 'stockStats'));
    }
    public function dashboard()
    {
        return view('dashboard.index');
    }
}
