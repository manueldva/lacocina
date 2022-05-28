<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoantecedentemedico extends Model
{
    //use HasFactory;

    protected $table = 'tipoantecedentesmedicos';

	protected $fillable = [
    	'descripcion', 'activo'
	];

    
    public function scopeBuscarpor($query, $tipo, $buscar) {
        if ( ($tipo) && ($buscar) ) {
            return $query->where($tipo,'like',"%$buscar%");
        }
    }
}
