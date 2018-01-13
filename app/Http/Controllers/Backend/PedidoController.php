<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Rol;
use App\Permiso;
use App\Notificacion;
use App\Proveedor;
use App\Pedido;
use App\DetallePedido;
use App\Envio;
use App\Mensajero;
class PedidoController extends Controller
{
    private $notificaciones;
    public function __construct()
    {
        $this->middleware(function ($request, $next) 
        {
            $rol = Rol::where('id', Auth::user()->rol_id)->first();
            $permisos = Permiso::where('rol_id',$rol->id)->where('ruta','admin/pedidos')->first();
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
    public function proveedores()
    {
    	$notificaciones = $this->notificaciones;
    	$proveedores = DB::table('proveedores')
    					->join('users','users.id','=','proveedores.user_id')
                        ->join('tipos','tipos.id','=','proveedores.tipo_id')
    					->select('proveedores.id','proveedores.logo','proveedores.nombre_comercial','proveedores.direccion','proveedores.habilitado', 'proveedores.whatsapp','users.name as representante','tipos.nombre as tipo','proveedores.created_at','proveedores.precio','proveedores.updated_at')
    					->orderBy('proveedores.updated_at','desc')
    					->paginate(config('app.paginacion'));

    	return view('Backend.pedidos.proveedores',compact('proveedores','notificaciones'));
    }

    function comision_editar($id, $comision)
    {
        $proveedor = Proveedor::where('id',$id)->first();
        $proveedor->precio = $comision;
        $proveedor->save();
        
    }

    function en_cola()
    {
        $notificaciones = $this->notificaciones;
        $pedidos = DB::table('pedidos')
                    ->join('lugares','lugares.id','=','pedidos.lugar_id')
                    ->join('users','users.id','=','lugares.user_id')
                    ->join('cupones','cupones.id','=','pedidos.cupon_id')
                    ->join('estados','estados.id','=','pedidos.estado_id')
                    ->join('pagos','pagos.id','=','pedidos.pago_id')
                    ->select('pedidos.id','pedidos.created_at', 'users.foto', 'users.name', 'lugares.direccion','estados.nombre as estado','pagos.nombre as pago','pedidos.total','pedidos.imagen','pedidos.updated_at','cupones.nombre as cupon')
                    ->where([['pedidos.estado_id','<',4]])
                    ->orderBy('pedidos.updated_at','desc')

                    ->paginate(config('app.paginacion'));

        return view('backend.pedidos.encola',compact('pedidos','notificaciones'));
    }

    function carrito($id)
    {
        // $carrito = DetallePedido::where('pedido_id',$id)->get();
        $carrito = DB::table('detalle_pedidos')
                    ->join('productos','productos.id','=','detalle_pedidos.producto_id')
                    ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
                    ->join('proveedores','proveedores.id','=','productos.proveedor_id')
                    ->join('users','users.id','=','proveedores.user_id')
                    ->select('productos.id','productos.nombre','detalle_pedidos.precio','detalle_pedidos.cantidad','proveedores.nombre_comercial','proveedores.direccion','proveedores.whatsapp','detalle_pedidos.entregado','users.name')
                    ->where('pedidos.id','=',$id)
                    ->get();

        return $carrito;
    }
    function mensajero($id)
    {
        $mensajero = DB::table('envios')
                        ->join('mensajeros','mensajeros.id','=','envios.mensajero_id')
                        ->join('users','users.id','=','mensajeros.user_id')
                        ->join('vehiculos','vehiculos.id','=','mensajeros.vehiculo_id')
                        ->join('pedidos','pedidos.id','=','envios.pedido_id')
                        ->select('mensajeros.id','mensajeros.alias', 'users.name', 'vehiculos.nombre as vehiculo','vehiculos.ruedas','envios.distancia','envios.imagen','envios.created_at')
                        ->where('pedidos.id','=',$id)
                        ->get();
        return json_encode($mensajero);
    }

    function asignar_mensajero($mensajero_id, $pedido_id)
    {
        //registrando el mensajero al pedido
        Envio::create([
            'mensajero_id' => $mensajero_id,
            'pedido_id' => $pedido_id

        ]);

        // notificacion al Mensajero
        $mensajero= DB::table('mensajeros')
                    ->join('users','users.id','=','mensajeros.user_id')
                    ->where('mensajeros.id','=',$mensajero_id)
                    ->select('mensajeros.alias','users.id')
                    ->first();
        // return $mensajero;
        Notificacion::create([
            'mensaje' => $mensajero->alias.' - Se te asigno el pedido #'.$pedido_id.', Tiempo para la entrega '.config('app.tiempo_aprox_entrega, Buena suerte.'),
            'ruta' => '/mensajero/mapa/'.$pedido_id,
            'user_id' => $mensajero->id
        ]);

        $pedido = Pedido::where('id','=',$pedido_id)->first();
        $pedido->estado_id = 2;
        $pedido->save();

        // return redirect('admin/mensajeros');
        return back();
    }

    //-------------------------------------------------------
    //para usuarios
    function pedidos_usuario($id)
    {
        $pedidos = DB::table('pedidos')
                    ->join('lugares','lugares.id','=','pedidos.lugar_id')
                    ->join('users','users.id','=','lugares.user_id')
                    ->select('pedidos.*', 'lugares.direccion','users.whatsapp')
                    ->where('users.id','=', $id)
                    ->orderBy('pedidos.created_at','desc')
                    ->get();
        return $pedidos;
    }
    // function negocios($id)
    // {
    //     $negocios = DB::table('detalle_pedidos')
    //                 ->join('productos','productos.id','=','detalle_pedidos.producto_id')
    //                 ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
    //                 ->join('proveedores','proveedores.id','=','productos.proveedor_id')
    //                 ->select('proveedores.id','proveedores.nombre_comercial','proveedores.direccion','proveedores.whatsapp')
    //                 ->where('pedidos.id','=',$id)
    //                 ->get();
    //     return $negocios;
    // }

    public function cancelar($id)
    {
        $pedido = Pedido::where('id',$id)->first();
        $pedido->estado_id = 5;
        $pedido->subTotal = 0;
        $pedido->comision = 0;
        $pedido->total = 0;
        $pedido->save();

        $detalle = DetallePedido::where('pedido_id',$id)->get();

        foreach ($detalle as $item) 
        {
            # code...
            $detalles = DetallePedido::where('id',$item->id)->first();
            $detalles->entregado=0;
            $detalles->save();
        }
    }

    function historico()
    {
        $notificaciones = $this->notificaciones;
        $pedidos = DB::table('pedidos')
                    ->join('lugares','lugares.id','=','pedidos.lugar_id')
                    ->join('users','users.id','=','lugares.user_id')
                    ->join('cupones','cupones.id','=','pedidos.cupon_id')
                    ->join('estados','estados.id','=','pedidos.estado_id')
                    ->join('pagos','pagos.id','=','pedidos.pago_id')
                    ->select('pedidos.id','pedidos.created_at', 'users.foto', 'users.name', 'lugares.direccion','estados.nombre as estado','pagos.nombre as pago','pedidos.subTotal','pedidos.comision','pedidos.total','pedidos.imagen','pedidos.updated_at','cupones.nombre as cupon')
                    ->where([['pedidos.estado_id','>=',4]])
                    ->orderBy('pedidos.created_at','desc')
                    ->paginate(config('app.paginacion'));
        //return $pedidos;
        return view('backend.pedidos.historico',compact('pedidos','notificaciones'));
    }

    function mensajeros_all()
    {
        $mensajeros = DB::table('mensajeros')
                        ->join('users','users.id','=','mensajeros.user_id')
                        ->select('mensajeros.*','users.*','mensajeros.id as mensajero_id')
                        ->get();

        return json_encode($mensajeros);
    }

    function items()
    {
        $items = DB::table('productos')
                    ->join('categorias','categorias.id','=','productos.categoria_id')
                    ->join('proveedores','proveedores.id','=','productos.proveedor_id')
                    ->select('productos.id','productos.nombre', 'productos.descripcion', 'categorias.nombre as categoria','productos.precio','productos.cantidad','productos.habilitado','productos.created_at','productos.updated_at','productos.imagen','proveedores.nombre_comercial','proveedores.direccion','proveedores.atencion','proveedores.logo')
                    ->orderBy('productos.updated_at','desc')
                    ->paginate(config('app.paginacion'));

        $totales = DB::table('productos')
                    ->join('categorias','categorias.id','=','productos.categoria_id')
                    ->join('proveedores','proveedores.id','=','productos.proveedor_id')
                    ->select(DB::raw('SUM(productos.precio) as precioT'), DB::raw('SUM(productos.cantidad) as cantidadT'), DB::raw('count(productos.id) as itemsT'))
                    // ->orderBy('productos.updated_at','desc')
                    // ->paginate(config('app.paginacion'));
                    ->first();

        $itemsT = $totales->itemsT;
        $precioT = $totales->precioT;
        $cantidadT = $totales->cantidadT;
        //return $totales;
        $notificaciones = $this->notificaciones;
        return view('backend.pedidos.items',compact('items','notificaciones','itemsT','precioT','cantidadT'));

    }
}
