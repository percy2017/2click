<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $table = 'envios';
    protected $fillable = [
        'distancia', 'imagen', 'mensajero_id', 'pedido_id'
    ];
}
