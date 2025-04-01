<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $table = 'fournisseurs';
    protected $primaryKey = 'id_fournisseur';

    protected $fillable = [
        'nom',
        'contact',
        'email',
        'telephone',
        'adresse',
        'site_web',
    ];

    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modification';
}