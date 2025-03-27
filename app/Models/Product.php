<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'nom',
        'description',
        'quantite',
        'seuil_alerte',
        'id_fournisseur',
        'prix_achat',
        'prix_vente',
        'date_creation'
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'id_fournisseur');
    }

    public function mouvements()
    {
        return $this->hasMany(Movement::class, 'id_produit');
    }
}