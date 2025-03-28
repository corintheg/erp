<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $table = 'livraisons';

    protected $primaryKey = 'id_livraison';

    protected $fillable = [
        'reference_commande',
        'id_fournisseur',
        'destinataire',
        'statut_livraison',
        'date_creation',
        'date_livraison',
        'commentaires',
    ];


    public $timestamps = false;
    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'id_fournisseur', 'id_fournisseur');
    }
}
