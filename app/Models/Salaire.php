<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salaire extends Model
{
    use HasFactory;

    protected $table = 'salaire';
    protected $primaryKey = 'id_salaire';
    protected $fillable = ['id_employe', 'montant', 'date_debut', 'date_fin'];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe');
    }
}