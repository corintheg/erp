<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Utilisateur extends Authenticatable
{
    protected $table = 'utilisateurs';

    protected $primaryKey = 'id_utilisateur';

    protected $fillable = ['username', 'mot_de_passe'];

    protected $hidden = ['mot_de_passe']; // Cache le mot de passe dans les JSON

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function setPasswordAttribute($value)
    {
        // Laravel pense que password existe → on bloque
        // Ne rien faire pour empêcher l'update
    }
}

