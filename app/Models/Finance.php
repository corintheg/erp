<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $table = 'finances';
    protected $primaryKey = 'id_finance';

    public $timestamps = false;

    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';

    protected $fillable = [
        'type_operation',
        'description',
        'montant',
        'date_operation',
        'categorie',
        'id_fournisseur',
        'statut',
        'reference_facture',
        'date_creation'
    ];

    public function fournisseur()
    {
        return $this->belongsTo(\App\Models\Fournisseur::class, 'id_fournisseur', 'id_fournisseur');
    }
}
