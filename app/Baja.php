<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    protected $table = 'bajas';
    protected $fillable = [
        'pedido_id', 'clasificacion_id', 'user_id', 'descripcion'
    ];
}
