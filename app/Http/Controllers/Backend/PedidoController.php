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
use APp\Pedido;
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
    					->select('proveedores.id','proveedores.logo','proveedores.nombre_comercial','proveedores.direccion','proveedores.habilitado', 'proveedores.whatsapp','users.name as representante','tipos.nombre as tipo','proveedores.created_at','proveedores.precio')
    					->orderBy('proveedores.created_at','desc')
    					->paginate(config('app.paginacion'));

    	return view('Backend.pedidos.proveedores',compact('proveedores','notificaciones'));
    }

    function comision_editar($id, $comision)
    {
        $proveedor = Proveedor::where('id',$id)->first();
        $proveedor->precio = $comision;
        $proveedor->save();
        
    }
}
