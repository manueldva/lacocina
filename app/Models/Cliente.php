<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	use HasFactory;

    protected $table = 'clientes';

	protected $fillable = [
    	'persona_id', 'ocasional', 'envioadocimilio' ,'activo'
	];

	public function persona()
    {
        return $this->hasOne(Persona::class);
    }


    public function scopeBuscarpor($query, $tipo, $buscar) {
    	if ( ($tipo) && ($buscar) ) {
    		return $query->where($tipo,'like',"%$buscar%");
    	}
    }

}
