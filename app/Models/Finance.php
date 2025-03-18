<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Finance extends Model
{
    use HasFactory;

    protected $table = 'finances';
    protected $primaryKey = 'id_finance';
    protected $fillable = [
        'type_operation',
        'description',
        'montant',
        'date_operation',
        'categorie',
        'id_fournisseur',
        'statut',
        'reference_facture'
    ];
}
