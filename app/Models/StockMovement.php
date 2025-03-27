<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';

    protected $fillable = ['id_produit', 'type', 'quantite', 'date', 'commentaire'];

    public function produit()
    {
        return $this->belongsTo(Product::class, 'id_produit');
    }
}
