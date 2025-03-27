<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $primaryKey = 'id_produit';

    protected $fillable = [
        'id_fournisseur', // Ajouté ici
        'nom_produit',
        'description',
        'quantite',
        'seuil_alerte',
        'prix_achat',
        'prix_vente',
        'date_creation',
        'date_modification'
    ];

    public $timestamps = false;
    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';

    public function fournisseur()
    {
        return $this->belongsTo(\App\Models\Fournisseur::class, 'id_fournisseur', 'id_fournisseur');
    }
}
