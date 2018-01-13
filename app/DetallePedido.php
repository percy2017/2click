<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalle_pedidos';
    protected $fillable = [
        'producto_id', 'pedido_id', 'precio', 'cantidad', 'entregado'
    ];
}
