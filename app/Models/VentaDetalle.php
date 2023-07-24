<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;

    protected $table = 'ventadetalles';

    protected $fillable = [
        'venta_id',
        'vianda_id',
        'cantidad',
        'precio',
    ];
    
    // Relación con el modelo Venta
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    // Relación con el modelo Vianda
    public function vianda()
    {
        return $this->belongsTo(Vianda::class);
    }
}
