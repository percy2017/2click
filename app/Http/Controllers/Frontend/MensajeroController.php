<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notificacion;
use App\Envio;
use App\Mensajero;
use App\Pedido;
use App\Rol;
use App\Permiso;
class MensajeroController extends Controller
{
    //

    public function __construct()
    {
    	// if(!\Session::has('carrito')) \Session::put('carrito',array());
        $this->middleware(function ($request, $next) 
        {
            $rol = Rol::where('id', Auth::user()->rol_id)->first();
            $permisos = Permiso::where('rol_id',$rol->id)->where('ruta','mensajeros')->first();
            if ($permisos) 
            {
                return $next($request);
            }else
            {
                return redirect('denegado');
            }
            
        });
    }
    public function index()
    {
    	// $pedidos = DB::table('pedidos')
    	// 			->join('estados','estados.id','=','pedidos.estado_id')
    	// 			->join('lugares','lugares.id','=','pedidos.lugar_id')
    	// 			->join('users','users.id','=','lugares.user_id')
     //                // ->join('envios','envios.pedido_id','=','pedidos.id')
    	// 			->select('pedidos.id','users.name','users.redsocial','users.foto','pedidos.created_at','lugares.direccion as destino')
     //                // ->where('envios')
    	// 			->orderBy('pedidos.created_at','desc')
    	// 			->get();
    	//  $notificaciones = Notificacion::where('user_id', Auth::user()->id ? Auth::user()->id : 0 )->where('visto',0)->orderBy('created_at','desc')->get();
        // return 'hola';
        $pedidos = DB::table('pedidos')
                    ->join('lugares','lugares.id','=','pedidos.lugar_id')
                    ->join('users','users.id','=','lugares.user_id')
                    ->select('pedidos.id','users.name','users.redsocial','users.foto','pedidos.created_at','lugares.direccion as destino')  
                      ->whereNotExists(function($query){
                        $query->select('envios.pedido_id')
                                ->from('envios')
                                ->whereRaw('envios.pedido_id = pedidos.id');
                      })
                      ->where('pedidos.estado_id','!=',5)
                      ->orderBy('pedidos.created_at','desc')
                      ->get();
        $notificaciones = Notificacion::where('user_id', Auth::user()->id ? Auth::user()->id : 0 )->where('visto',0)->orderBy('created_at','desc')->get();
    	// return $pedidos;
        // return 'hola';
    	return view('frontend.mensajeros.index',compact('pedidos','notificaciones'));
    }
    function carrito($id)
    {
        // $carrito = DetallePedido::where('pedido_id',$id)->get();
        $carrito = DB::table('detalle_pedidos')
                    ->join('productos','productos.id','=','detalle_pedidos.producto_id')
                    ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
                    ->join('proveedores','proveedores.id','=','productos.proveedor_id')
                    ->select('productos.id','productos.nombre','detalle_pedidos.precio','detalle_pedidos.cantidad','proveedores.nombre_comercial','proveedores.direccion','productos.imagen')
                    ->where('pedidos.id','=',$id)
                    ->get();

        return $carrito;
    }

    function mapa($pedido_id)
    {

        $pedido = Pedido::where('id','=',$pedido_id)->first();
        //Obtener proveedores
        $proveedores = DB::table('detalle_pedidos')
                    ->join('productos','productos.id','=','detalle_pedidos.producto_id')
                    ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
                    ->join('proveedores','proveedores.id','=','productos.proveedor_id')
                    ->select('proveedores.*')
                    ->where('pedidos.id','=',$pedido_id)
                    ->get();
        // // obtener productos
        $productos = DB::table('detalle_pedidos')
                    ->join('productos','productos.id','=','detalle_pedidos.producto_id')
                    ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
                    ->select('productos.*')
                    ->where('pedidos.id','=',$pedido_id)
                    ->get();

        // //obtener lugar y user
        $destino = DB::table('lugares')
                    ->join('users','users.id','=','lugares.user_id')
                    ->join('pedidos','pedidos.lugar_id','=','lugares.id')
                    ->select('lugares.*','users.*')
                    ->where('pedidos.id','=',$pedido_id)
                   ->first();

        $notificaciones = Notificacion::where('user_id', Auth::user()->id ? Auth::user()->id : 0 )->where('visto',0)->orderBy('created_at','desc')->get();

        // return $pedido_id;
        return view('frontend.mensajeros.mapa',compact('pedido','notificaciones','proveedores','productos','destino'));
    }

    function historico()
    {
        $mensajero = Mensajero::where('user_id','=',Auth::user()->id)->first();
        $pedidos = DB::table('pedidos')
                    ->join('lugares','lugares.id','=','pedidos.lugar_id')
                    ->join('users','users.id','=','lugares.user_id')
                    ->join('envios','envios.pedido_id','=','pedidos.id')
                    ->select('pedidos.id','users.name','users.redsocial','users.foto','pedidos.created_at','lugares.direccion as destino')
                    ->where('envios.mensajero_id','=',$mensajero->id)  
                    ->orderBy('pedidos.created_at','desc')
                    ->get();

        $notificaciones = Notificacion::where('user_id', Auth::user()->id ? Auth::user()->id : 0 )->where('visto',0)->orderBy('created_at','desc')->get();
        // return $pedidos;
        return view('frontend.mensajeros.historico',compact('pedidos','notificaciones'));
    }
    function asignar($pedido_id)
    {
        //Asignar mensajero a pedido
        $mensajero = Mensajero::where('user_id','=',Auth::user()->id)->first();
        Envio::create([
        'mensajero_id' => $mensajero->id,
        'pedido_id' => $pedido_id
        ]);

        //pedido
        $pedido = Pedido::where('id','=',$pedido_id)->first();
        $pedido->estado_id = 2;
        $pedido->save();

        // crea notificacion al mensajero
         Notificacion::create([
            'mensaje' => Auth::user()->name.', Tomaste el pedido #'.$pedido->id.', Buena suerte.',
            'ruta' => '/mensajero/historico',
            'user_id' => Auth::user()->id

        ]);

        //Cargas las notificaciones 
        // $notificaciones = Notificacion::where('user_id', Auth::user()->id ? Auth::user()->id : 0 )->where('visto',0)->orderBy('created_at','desc')->get();

        //---------------------------------------------------------------------------

        //Obtener proveedores
        // $proveedores = DB::table('detalle_pedidos')
        //             ->join('productos','productos.id','=','detalle_pedidos.producto_id')
        //             ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
        //             ->join('proveedores','proveedores.id','=','productos.proveedor_id')
        //             ->select('proveedores.*')
        //             ->where('pedidos.id','=',$pedido_id)
        //             ->get();

        // // obtener productos
        // $productos = DB::table('detalle_pedidos')
        //             ->join('productos','productos.id','=','detalle_pedidos.producto_id')
        //             ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
        //             ->select('productos.*')
        //             ->where('pedidos.id','=',$pedido_id)
        //             ->get();

        // //obtener lugar y user
        // $destino = DB::table('lugares')
        //             ->join('users','users.id','=','lugares.user_id')
        //             ->join('pedidos','pedidos.lugar_id','=','lugares.id')
        //             ->select('lugares.*','users.*')
        //             ->where('pedidos.id','=',$pedido_id)
        //            ->first();

         // return json_encode($destino);
        // return redirect('mensajeros/historico');
         // return view('frontend.mensajeros.mapa',compact('pedido','notificaciones','proveedores','productos','destino'));
        // return redirect('admin/mensajeros');
    }

    public function entregar($id)
    {
        $pedido = Pedido::where('id',$id)->first();
        $pedido->estado_id = 4;
        $pedido->save();
    }
}
