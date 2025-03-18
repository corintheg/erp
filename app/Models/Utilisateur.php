<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Utilisateur extends Authenticatable
{
    protected $table = 'utilisateurs';

    protected $fillable = ['username', 'mot_de_passe'];

    protected $hidden = ['mot_de_passe']; // Cache le mot de passe dans les JSON

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}
