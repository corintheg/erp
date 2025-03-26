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
        'telephone',
        'date_embauche',
        'departement',
    ];

    public $timestamps = false;

    public function salaires()
    {
        return $this->hasMany(Salaire::class, 'id_employe');
    }

}