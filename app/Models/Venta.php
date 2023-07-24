<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tipopago;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'cliente_id',
        'tipopago_id',
        'fechanacimiento',
        'total',
        'totalpagado',
        'envio',
    ];


    // Relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con el modelo TipoPago
    public function tipoPago()
    {
        return $this->belongsTo(Tipopago::class, 'tipopago_id');
    }

    // Relación con el modelo VentaDetalle
    public function ventaDetalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    
}
