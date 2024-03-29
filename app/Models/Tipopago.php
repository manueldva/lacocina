<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipopago extends Model
{
    use HasFactory;

    protected $table = 'tipopagos';

	protected $fillable = [
    	'descripcion','recargo','porcentajerecargo','activo'
	];

    // Relación con el modelo Venta
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
    
    public function scopeBuscarpor($query, $tipo, $buscar) {
        if ( ($tipo) && ($buscar) ) {
            return $query->where($tipo,'like',"%$buscar%");
        }
    }
}
