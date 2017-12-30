<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = [
        'nombre', 'descripcion', 'imagen', 'precio', 'cantidad', 'habilidato', 'categoria_id', 'proveedor_id'
    ];
}
