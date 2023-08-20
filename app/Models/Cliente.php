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

    public function MetodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodopago_id');
    }



    public function scopeBuscarpor($query, $tipo, $buscar) {
    	if ( ($tipo) && ($buscar) ) {
    		//return $query->where($tipo,'like',"%$buscar%");
			return $query->whereHas('persona', function ($personas) use($tipo, $buscar) {
    			$personas->where($tipo,'like',"%$buscar%");
			})->orderBy('id', 'DESC');
    	}

    }

    public function totalPrecioViandas()
    {
        return $this->viandas->sum(function ($vianda) {
            return ($vianda->pivot->cantidad * $vianda->precio) * $this->metodoPago->dias;
        });
    }
	/*public function scopeWithMontoAdeudado(Builder $query)
    {
        $query->select('clientes.*')
            ->selectRaw('(SELECT SUM(total) FROM ventas WHERE ventas.cliente_id = clientes.id) - (SELECT SUM(totalpagado) FROM ventas WHERE ventas.cliente_id = clientes.id) AS monto_adeudado');
    }*/

	
	
    /*public function scopeWithMontoAdeudado(Builder $query)
    {
        $query->select('clientes.*')
            ->selectSub(function ($subquery) {
                $subquery->selectRaw('COALESCE(SUM(total), 0)')
                    ->from('ventas')
                    ->whereColumn('ventas.cliente_id', 'clientes.id');
            }, 'monto_ventas')
            ->selectSub(function ($subquery) {
                $subquery->selectRaw('COALESCE(SUM(totalpagado), 0)')
                    ->from('ventas')
                    ->whereColumn('ventas.cliente_id', 'clientes.id');
            }, 'monto_pagado')
            ->addSelect(['monto_adeudado' => function ($query) {
                $query->selectRaw('monto_ventas - monto_pagado');
            }]);
    }*/


	/*public function scopeWithMontoAdeudado(Builder $query, $fechaDesde = null, $fechaHasta = null) //sacar cuando se elimina del informe
    {
        $query->select('clientes.*')
            ->selectSub(function ($subquery) use ($fechaDesde, $fechaHasta) {
                $subquery->selectRaw('COALESCE(SUM(total), 0)')
                    ->from('ventas')
                    ->whereColumn('ventas.cliente_id', 'clientes.id');
                if ($fechaDesde) {
                    $subquery->where('fecha', '>=', $fechaDesde);
                }

                if ($fechaHasta) {
                    $subquery->where('fecha', '<=', $fechaHasta);
                }
            }, 'monto_ventas')
            ->selectSub(function ($subquery) use ($fechaDesde, $fechaHasta) {
                $subquery->selectRaw('COALESCE(SUM(totalpagado), 0)')
                    ->from('ventas')
                    ->whereColumn('ventas.cliente_id', 'clientes.id');

                if ($fechaDesde) {
                    $subquery->where('fecha', '>=', $fechaDesde);
                }

                if ($fechaHasta) {
                    $subquery->where('fecha', '<=', $fechaHasta);
                }
            }, 'monto_pagado')
            ->addSelect(['monto_adeudado' => function ($query) {
                $query->selectRaw('monto_ventas - monto_pagado');
            }]);
    }*/


    /*public function scopeMontoAdeudado($query)
    {
        return $query->addSelect(['deuda' => function ($subquery) {
            $subquery->selectRaw('SUM(ventadetalles.cantidad * ventadetalles.precio * metodopagos.dias)')
                ->from('ventas')
                ->join('ventadetalles', 'ventadetalles.venta_id', '=', 'ventas.id')
                ->join('metodopagos', 'metodopagos.id', '=', 'ventas.metodopago_id')
                ->whereColumn('ventas.cliente_id', 'clientes.id')
                ->where('ventas.pago', 0);
        }]);
    }*/


    public function scopeMontoAdeudado($query)
    {
        return $query->addSelect(['deuda' => function ($subquery) {
            $subquery->selectRaw('SUM(ventas.total - ventas.totalpagado)')
                ->from('ventas')
                ->whereColumn('ventas.cliente_id', 'clientes.id')
                ->where('ventas.pago', 0);
        }]);
    }
}
