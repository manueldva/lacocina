<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	use HasFactory;

    protected $table = 'clientes';

	protected $fillable = [
    	'persona_id', 'envioadocimilio' ,'activo'
	];

	/*public function persona()
    {
        return $this->hasOne(Persona::class);
    }*/

	public function persona(){
		
		return $this->belongsTo(Persona::class);
	}


    public function scopeBuscarpor($query, $tipo, $buscar) {
    	if ( ($tipo) && ($buscar) ) {
    		//return $query->where($tipo,'like',"%$buscar%");
			return $query->whereHas('persona', function ($personas) use($tipo, $buscar) {
    			$personas->where($tipo,'like',"%$buscar%");
			})->orderBy('id', 'DESC');
    	}

    }

}
