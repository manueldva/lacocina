<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

	protected $fillable = [
    	'apellido','nombre', 'nrodocumento' , 'fechanacimiento', 'activo'
	];


    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }
}
