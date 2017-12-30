<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    protected $table = 'lugares';
    protected $fillable = [
        'direccion', 'latitud', 'longitud', 'habilitado', 'referencia_id','user_id'
    ];
}
