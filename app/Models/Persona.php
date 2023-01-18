<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //use HasFactory;

    protected $table = 'personas';

	protected $fillable = [
    	'apellido','nombre' , 'fechanacimiento','documento','domicilio' ,'activo'
	];


    /*public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }*/

    public function cliente(){
    	return $this->hasOne(Cliente::class);
    }

    public function scopeBuscarpor($query, $tipo, $buscar) {
    	if ( ($tipo) && ($buscar) ) {
    		return $query->where($tipo,'like',"%$buscar%");
    	}
    }
}
