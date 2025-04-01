<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absence extends Model
{
    use HasFactory;

    protected $table = 'absences';
    protected $fillable = ['id_employe', 'date_absence', 'motif'];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe', 'id_employe');
    }
}
