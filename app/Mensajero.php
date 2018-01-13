<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensajero extends Model
{
    protected $table = 'mensajeros';
    protected $fillable = [
        'alias', 'imagen_permiso', 'imagen_placa', 'imagen_inspeccion', 'imagen_soat', 'habilitado', 'user_id', 'vehiculo_id'
    ];
}
