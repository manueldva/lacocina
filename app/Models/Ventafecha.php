<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventafecha extends Model
{
    use HasFactory;

    protected $table = 'ventafechas';

    protected $fillable = [
        'venta_id',
        'fecha',
        'envio',
        'entregado',
    ];



    // Relación con el modelo Venta
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
