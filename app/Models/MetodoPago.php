<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;

    protected $table = 'metodopagos';

	protected $fillable = [
    	'descripcion','dias','aviso','activo'
	];


    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

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
