<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    protected $table = 'cupones';
    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'habilitado', 'descuento'
    ];
}
