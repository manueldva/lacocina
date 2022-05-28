<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedentemedico extends Model
{
      //use HasFactory;

      protected $table = 'antecedentesmedicos';

      protected $fillable = [
          'tipoantecedentemedico_id', 'descripcion', 'activo'
      ];
  
      
      public function scopeBuscarpor($query, $tipo, $buscar) {
          if ( ($tipo) && ($buscar) ) {
              return $query->where($tipo,'like',"%$buscar%");
          }
      }
}
