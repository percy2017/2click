<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notificacion;
use App\User;
use App\Lugar;
class MapaController extends Controller
{
    public function __construct()
    {
    	if(!\Session::has('carrito')) \Session::put('carrito',array());   
    }

    function guardar(Request $request)
    {
    	// return $request;
    	Lugar::create([
    		'direccion' => $request->direccion,
    		'latitud' => $request->latitud,
    		'longitud' => $request->longitud,
    		'user_id' => Auth::user()->id,
    		'referencia_id' => $request->referencia_id	
    	]);
    	 Notificacion::create([
            'mensaje' => 'Bien echo '.Auth::user()->name.', ya tienes una nueva locacion donde llegaran tus pedidos.',
            'ruta' => '/perfil',
            'user_id' => Auth::user()->id
        ]);
    	return back();
    }
}
