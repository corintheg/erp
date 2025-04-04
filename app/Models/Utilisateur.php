<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Utilisateur extends Authenticatable
{
    protected $table = 'utilisateurs';

    protected $primaryKey = 'id_utilisateur';

    protected $fillable = [
        'id_employe',
        'username',
        'mot_de_passe',
        'email',
        'date_creation',
        'date_modification'
    ];

    protected $hidden = ['mot_de_passe'];

    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';

    /**
     * Retourne le mot de passe pour l'authentification.
     * Laravel utilisera cette méthode pour récupérer le hash.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * Accessor pour l'attribut "password" qui redirige vers "mot_de_passe"
     */
    public function getPasswordAttribute()
    {
        return $this->attributes['mot_de_passe'];
    }

    /**
     * Mutator pour l'attribut "password" qui écrit dans "mot_de_passe"
     */
    public function setPasswordAttribute($value)
    {
        // On hash le mot de passe avant de le stocker
        $this->attributes['mot_de_passe'] = Hash::make($value);
    }

    /**
     * Relation Many-to-Many avec les rôles.
     */
    public function roles()
    {
        return $this->belongsToMany(
            \App\Models\Role::class,
            'utilisateurs_roles',
            'id_utilisateur',
            'id_role'
        );
    }

    /**
     * Vérifie si l'utilisateur possède un rôle donné.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles->contains('nom_role', $roleName);
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->roles->pluck('nom_role')->intersect($roles)->isNotEmpty();
    }

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe', 'id_employe');
    }
    public function conges()
    {
        return $this->hasMany(Conge::class, 'id_employe', 'id_employe');
    }


    protected static function booted()
    {
        static::created(function ($utilisateur) {
            $role = Role::where('nom_role', 'employe')->first();

            if ($role) {
                    $utilisateur->roles()->attach($role->id_role);
            }
        });
    }

}