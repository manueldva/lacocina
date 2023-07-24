<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cliente extends Model
{
	use HasFactory;

    protected $table = 'clientes';

	protected $fillable = [
    	'persona_id', 'envioadocimilio', 'metodopago_id' ,'activo'
	];

	/*public function persona()
    {
        return $this->hasOne(Persona::class);
    }*/

	public function persona(){
		
		return $this->belongsTo(Persona::class);
	}

	public function viandas()
	{
		return $this->belongsToMany(Vianda::class, 'clienteviandas', 'cliente_id', 'vianda_id')
			->withPivot('cantidad')
			->withTimestamps()
			->select('viandas.id as vianda_id', 'viandas.descripcion', 'clienteviandas.cantidad','viandas.precio');
	}

	// Relación con el modelo Venta
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }


    public function scopeBuscarpor($query, $tipo, $buscar) {
    	if ( ($tipo) && ($buscar) ) {
    		//return $query->where($tipo,'like',"%$buscar%");
			return $query->whereHas('persona', function ($personas) use($tipo, $buscar) {
    			$personas->where($tipo,'like',"%$buscar%");
			})->orderBy('id', 'DESC');
    	}

    }

	public function scopeWithMontoAdeudado(Builder $query)
    {
        $query->select('clientes.*')
            ->selectRaw('(SELECT SUM(total) FROM ventas WHERE ventas.cliente_id = clientes.id) - (SELECT SUM(totalpagado) FROM ventas WHERE ventas.cliente_id = clientes.id) AS monto_adeudado');
    }

}
