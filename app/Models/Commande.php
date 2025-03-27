<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    // Nom de la table en base si différent de "commandes"
    protected $table = 'livraisons';

    // Clé primaire
    protected $primaryKey = 'id_livraison';

    // Champs remplissables en masse
    protected $fillable = [
        'reference_commande',
        'id_fournisseur',
        'destinataire',
        'statut_livraison',
        'date_creation',
        'date_livraison',
        'commentaires',
    ];

    // Si vous voulez que Laravel gère automatiquement created_at/updated_at,
    // vous pouvez désactiver et définir vos propres colonnes :
    public $timestamps = false;
    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';

    // Relation avec Fournisseur (si vous en avez une)
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'id_fournisseur', 'id_fournisseur');
    }
}
