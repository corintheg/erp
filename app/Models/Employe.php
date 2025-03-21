<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    // Définir le nom de la table si différent de 'employes'
    protected $table = 'employes';

    // Permet d'ajouter en masse ces colonnes avec `$employe->fill($data);`
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'date_embauche',
        'departement',
    ];

    // Désactiver les timestamps (si ta table ne contient pas `created_at` et `updated_at`)
    public $timestamps = false;


}
