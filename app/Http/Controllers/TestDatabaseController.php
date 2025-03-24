<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TestDatabaseController extends Controller
{
    public function index()
    {
        try {
            // Vérification de la connexion
            DB::connection()->getPdo();
            $message = "✅ Connexion réussie à la base de données.";

            // Tables à vérifier
            $tables = ['users', 'salaires', 'conges', 'absences', 'transactions', 'stocks', 'fournisseurs', 'livraisons', 'plannings', 'documents'];
            $tablesData = [];

            foreach ($tables as $table) {
                if (DB::getSchemaBuilder()->hasTable($table)) {
                    // Récupérer les données de la table
                    $data = DB::table($table)->get();
                    $tablesData[$table] = $data;
                } else {
                    $tablesData[$table] = null; // Table non trouvée
                }
            }

        } catch (\Exception $e) {
            $message = "❌ Erreur de connexion : " . $e->getMessage();
            $tablesData = [];
        }

        // Retourner la vue avec les données
        return view('test_database', compact('message', 'tablesData'));
    }
}