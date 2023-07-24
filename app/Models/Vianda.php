<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vianda extends Model
{
    use HasFactory;


    protected $table = 'viandas';

	protected $fillable = [
    	'descripcion', 'detalle', 'precio', 'activo'
	];

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'clienteviandas', 'vianda_id', 'cliente_id')
            ->withPivot('cantidad')
            ->withTimestamps()
            ->select('clientes.id as cliente_id', 'clienteviandas.cantidad');
    }

    // Relación con el modelo VentaDetalle
    public function ventaDetalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }
    
    public function scopeBuscarpor($query, $tipo, $buscar) {
        if ( ($tipo) && ($buscar) ) {
            return $query->where($tipo,'like',"%$buscar%");
        }
    }
}
