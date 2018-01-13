<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rol;
use App\Permiso;
use App\Notificacion;
use App\DetallePedido;
use App\Pedido;
class SolicitudController extends Controller
{
    private $notificaciones;
    public function __construct()
    {
        $this->middleware(function ($request, $next) 
        {
            $rol = Rol::where('id', Auth::user()->rol_id)->first();
            $permisos = Permiso::where('rol_id',$rol->id)->where('ruta','admin/solicitudes')->first();
            if ($permisos) 
            {
                $this->notificaciones = Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->orderBy('created_at','desc')->get();
                return $next($request);
            }else
            {
                return redirect('denegado');
            }
            
        });
    }

    public function index()
    {
    	$solicitudes = DB::table('detalle_pedidos')
    					->join('productos','productos.id','=','detalle_pedidos.producto_id')
    					->join('proveedores','proveedores.id','=','productos.proveedor_id')
    					->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
    					->join('estados','estados.id','=','pedidos.estado_id')
    					->where([['proveedores.user_id','=',Auth::user()->id]])
    					->select('detalle_pedidos.id', 'pedidos.id as pedido_id', 'detalle_pedidos.created_at','productos.imagen', 'productos.nombre', 'productos.descripcion','detalle_pedidos.precio','detalle_pedidos.cantidad','pedidos.estado_id')
    					->orderBy('detalle_pedidos.created_at','desc')
                        ->where([['detalle_pedidos.entregado','=',0],['pedidos.estado_id','!=',5]])
    					->paginate(config('app.paginacion'));
    					// ->get();
    	// return $solicitudes;
    	$notificaciones = $this->notificaciones;
        // return $solicitudes;
    	return view('backend.solicitudes.index',compact('solicitudes','notificaciones'));
    }

    function entregar($id, $pedido_id)
    {

        $detalle = DetallePedido::where('id','=',$id)->first();
        $detalle->entregado = 1;
        $detalle->save();

        //verificar que todos los articulos estan entregados
        $detalles = DB::table('detalle_pedidos')
                    ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
                    ->select('detalle_pedidos.*')
                    ->where('pedidos.id','=',$pedido_id)
                    ->get();

        $entregados=true;
        foreach ($detalles as $item) 
        {
            if($item->entregado == 0)
            {
                $entregados = false;
            }
        }
        
        if($entregados)
        {   
            $pedido = Pedido::where('id','=',$pedido_id)->first();
            $pedido->estado_id = 3;
            $pedido->save(); 
        }
        
    }

    //mensajero de la solicitud
    function mensajero($id)
    {
        $mensajero = DB::table('envios')
                        ->join('mensajeros','mensajeros.id','=','envios.mensajero_id')
                        ->join('users','users.id','=','mensajeros.user_id')
                        ->join('vehiculos','vehiculos.id','=','mensajeros.vehiculo_id')
                        ->join('pedidos','pedidos.id','=','envios.pedido_id')
                        ->select('mensajeros.id','mensajeros.alias', 'users.name','vehiculos.nombre as vehiculo','vehiculos.ruedas','envios.distancia','envios.imagen','envios.created_at')
                        ->where('pedidos.id','=',$id)
                        ->get();
        return json_encode($mensajero);
    }
}
