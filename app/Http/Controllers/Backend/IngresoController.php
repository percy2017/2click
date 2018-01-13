<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rol;
use App\Permiso;
use App\Notificacion;

class IngresoController extends Controller
{
    private $notificaciones;
    public function __construct()
    {
        $this->middleware(function ($request, $next) 
        {
            $rol = Rol::where('id', Auth::user()->rol_id)->first();
            $permisos = Permiso::where('rol_id',$rol->id)->where('ruta','admin/ingresos')->first();
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
    	$ingresos = DB::table('detalle_pedidos')
    					->join('productos','productos.id','=','detalle_pedidos.producto_id')
    					->join('proveedores','proveedores.id','=','productos.proveedor_id')
    					->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
    					->select('detalle_pedidos.id', 'pedidos.id as pedido_id', 'detalle_pedidos.created_at','productos.imagen', 'productos.nombre', 'productos.descripcion','detalle_pedidos.precio','detalle_pedidos.cantidad','detalle_pedidos.updated_at')
                        ->where([['proveedores.user_id','=',Auth::user()->id],['detalle_pedidos.entregado','=',1]])
    					->orderBy('detalle_pedidos.created_at','desc')
    					->paginate(config('app.paginacion'));
        
        $total = DB::table('detalle_pedidos')
                        ->join('productos','productos.id','=','detalle_pedidos.producto_id')
                        ->join('proveedores','proveedores.id','=','productos.proveedor_id')
                        ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
                        ->select(DB::raw('SUM(detalle_pedidos.cantidad * detalle_pedidos.precio) as total'))
                        ->where([['proveedores.user_id','=',Auth::user()->id],['detalle_pedidos.entregado','=',1]])
                        // ->groupBy('detalle_pedidos.cantidad','detalle_pedidos.precio')
                        ->first()->total;

        $items = DB::table('detalle_pedidos')
                ->join('productos','productos.id','=','detalle_pedidos.producto_id')
                ->join('proveedores','proveedores.id','=','productos.proveedor_id')
                ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
                ->select('detalle_pedidos.*')
                ->where([['proveedores.user_id','=',Auth::user()->id],['detalle_pedidos.entregado','=',1]])
                ->get();
        $items = count($items);

        // $precio = DB::table('detalle_pedidos')
        //                 ->join('productos','productos.id','=','detalle_pedidos.producto_id')
        //                 ->join('proveedores','proveedores.id','=','productos.proveedor_id')
        //                 ->join('pedidos','pedidos.id','=','detalle_pedidos.pedido_id')
        //                 ->select('detalle_pedidos.*')
        //                 ->where([['proveedores.user_id','=',Auth::user()->id],['detalle_pedidos.entregado','=',1]])
        //                 ->sum('detalle_pedidos.precio');

        // $total = $cantidad * $precio;
        //return $cantidad;
        // return $total;
    	$notificaciones = $this->notificaciones;
    	// return $total;
    	return view('backend.ingresos.index',compact('ingresos','notificaciones','total','items'));
    }
}
