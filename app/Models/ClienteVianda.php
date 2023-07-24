<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteVianda extends Model
{
    use HasFactory;

    protected $table = 'clienteviandas';

	protected $fillable = [
    	'cliente_id','vianda_id','cantidad'
	];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vianda()
    {
        return $this->belongsTo(Vianda::class);
    }
}
