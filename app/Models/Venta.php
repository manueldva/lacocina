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
        'metodopago_id',
        'fecha',
        'total',
        'pago',
        'estado'
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

    // Relación con el modelo Metodopago
    public function MetodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodopago_id');
    }


    // Relación con el modelo VentaDetalle
    public function ventaDetalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    public function ventafechas()
    {
        return $this->hasMany(Ventafecha::class);
    }

    public function cantidadTotalViandas()
    {
        return $this->ventaDetalles->sum('cantidad');
    }

    public function scopeBuscarpor($query, $tipo, $buscar) {
        if ($tipo && $buscar) {
            return $query->whereHas('cliente.persona', function ($personas) use ($tipo, $buscar) {
                $personas->where($tipo, 'like', "%$buscar%");
            })->orderBy('id', 'DESC');
        }
    }

    
}
