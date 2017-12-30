<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'nombre_comercial', 'logo', 'direccion', 'latitud', 'longitud', 'user_id', 'habilitado', 'whatsapp', 'precio','tipo_id'
    ];
}
