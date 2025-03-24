<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $table = 'employes';
    protected $primaryKey = 'id_employe';
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'departement',
        'date_embauche',
        'date_debauche'
    ];

    public $timestamps = false;

}
