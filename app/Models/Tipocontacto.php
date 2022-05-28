<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipocontacto extends Model
{
    use HasFactory;

    protected $table = 'tipoclientes';

	protected $fillable = [
    	'descripcion', 'activo'
	];

    
    public function scopeBuscarpor($query, $tipo, $buscar) {
        if ( ($tipo) && ($buscar) ) {
            return $query->where($tipo,'like',"%$buscar%");
        }
    }
}
