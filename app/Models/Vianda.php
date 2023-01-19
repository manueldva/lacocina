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

    
    public function scopeBuscarpor($query, $tipo, $buscar) {
        if ( ($tipo) && ($buscar) ) {
            return $query->where($tipo,'like',"%$buscar%");
        }
    }
}
