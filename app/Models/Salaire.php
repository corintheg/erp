<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salaire extends Model
{
    use HasFactory;

    protected $table = 'salaires';
    protected $primaryKey = 'id_salaire';
    public $timestamps = false;

    protected $fillable = ['id_employe', 'montant', 'date_debut', 'date_fin'];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe', 'id_employe');
    }
}
