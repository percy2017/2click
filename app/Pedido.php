<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $fillable = [
        'lugar_id', 'cupon_id', 'estado_id', 'pago_id', 'subTotal', 'comision' ,'total' ,'fecha_entrega', 'imagen'
    ];
}
