<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salaire extends Model
{
    protected $table = 'salaires';
    protected $primaryKey = 'id_salaire';
    public $timestamps = false;

    protected $fillable = [
        'id_employe',
        'montant',
        'date_debut',
        'date_fin',
        'date_creation',
        'date_modification',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_creation' => 'datetime',
        'date_modification' => 'datetime',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe');
    }
}