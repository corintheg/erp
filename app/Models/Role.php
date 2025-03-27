<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_role';

    // Si c'est auto-incrémenté
    public $incrementing = true;
    protected $keyType = 'int';

    // Pas de timestamps par défaut
    public $timestamps = false;

    protected $fillable = [
        'nom_role',
        'description',
    ];

    /**
     * Relation Many-to-Many inversée : un rôle peut appartenir à plusieurs utilisateurs
     */
    public function utilisateurs()
    {
        return $this->belongsToMany(
            Utilisateur::class,
            'utilisateurs_roles',
            'id_role',
            'id_utilisateur'
        );
    }
}