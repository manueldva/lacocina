<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipocliente extends Model
{
    use HasFactory;

    protected $table = 'tipoclientes';

	protected $fillable = [
    	'descripcion', 'activo'
	];

}
