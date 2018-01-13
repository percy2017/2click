<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notificacion;
use App\Lugar;
use App\Pago;
use App\Referencia;
use App\Pedido;
use App\Cupon;
use App\Localidad;
use App\DetallePedido;
use App\Producto;
class PedidoController extends Controller
{
	public function __construct()
    {
    	if(!\Session::has('carrito')) \Session::put('carrito',array());   
    }
    public function index()
    {
        $carrito= \Session::get('carrito');
        if (count($carrito)>0) 
        {
            if(Auth::user()->whatsapp && Auth::user()->carnet && (Auth::user()->localidad_id > 1))
            {
                $lugares = Lugar::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
                $referencias = Referencia::all();
                $pagos = Pago::all();
                $cupon = Cupon::where('habilitado',1)->first();
                $localidad = Localidad::where('id','=',Auth::user()->id)->where('id','<>',1)->first();
                $notificaciones = Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->orderBy('created_at','desc')->get();

                $cantProductos = $this->cantProductos();
                $cantProveedores = $this->cantProveedores();
                $total = $this->total();
                return view('frontend.pedido',compact('notificaciones','lugares','referencias','cantProductos','cantProveedores','total','cupon','pagos','localidad'));
            }else
            {

                return redirect('/perfil/editar')->with('mensaje_info', config('app.name').', necesita que el perfil este completo. para poder realizar el pedido.');
            }
        } else 
        {
            return redirect('/');
        }
        
        
    	


    }
    public function guardar(Request $request)
    {
        $carrito= \Session::get('carrito');

        $aux_array = array();
        $aux_prov = array();
        
        //llenados de los array's
        foreach ($carrito as $item) 
        { 
            $aux_array = array('idP' => $item->idP, 'proveedores' => $item->nombre_comercial, 'comision' => $item->comision);
            array_push($aux_prov, $aux_array);
        }

        //Eliminacion de los proveedores repetidos
        $duplicates = array_map("unserialize", array_unique(array_map("serialize", $aux_prov)));

        //registrando pedido
        $pedido = Pedido::create([
            'cupon_id' => $request->cupon_id ? $cupon_id : 1,
            'estado_id' => 1,
            'pago_id' => $request->pago_id,
            'subTotal' => $this->subTotal(),
            'comision' => $this->comision(),
            'total' => $this->total(),
            'lugar_id' => $request->lugar_id
        ]);

        //registrar detalles del pedido
        foreach($carrito as $item)
        {           
            DetallePedido::create([
                'producto_id' => $item->id,
                'pedido_id' => $pedido->id,
                'precio' => $item->precio,
                'cantidad' => $item->cantidad
            ]);

            //Disminuir la cantidad de los productos
            $producto = Producto::where('id',$item->id)->first();
            $producto->cantidad =  $producto->cantidad -  $item->cantidad;
            $producto->save();
        }

        //Regitro de las notificaciones a los proveedores
          foreach ($duplicates as $item) 
          {
              $usuario = DB::table('users')
                      ->join('proveedores', 'proveedores.user_id', '=', 'users.id')
                      ->select('users.id')
                      ->where('proveedores.id','=',$item['idP'])
                      ->first();
              Notificacion::create([
                'mensaje' => 'Tienes un pedido pendiente #'.$pedido->id,  
                'ruta' => 'admin/solicitudes',
                'user_id' => $usuario->id
                
              ]);
          }
        
        //notificacion al cliente
        Notificacion::create([
            'mensaje' => 'Pedido #'.$pedido->id.', realizado con exito.',
            'ruta' => '/perfil',
            'user_id' => Auth::user()->id
        ]);

        //vacio carrito
        \Session::forget('carrito');

        //redieccionando al perfil
        return redirect('/perfil')->with('mensaje_info','Pedido #'.$pedido->id.' se realizao correctamente');
    }
    public function cantProductos()
    {   
        $carrito= \Session::get('carrito');
        $total=0;
        foreach($carrito as $item)
        {
            $total+= $item->cantidad;
        }
        return $total;
    }
    public function cantProveedores()
    {
        $carrito= \Session::get('carrito');
        $total=0;
        $aux_prov = array();
        foreach($carrito as $item)
        {
            $aux_array = array('proveedores' => $item->nombre_comercial, 'comision' => $item->comision);
            array_push($aux_prov, $aux_array);
        }
        $duplicates = array_map("unserialize", array_unique(array_map("serialize", $aux_prov)));
        return count($duplicates);   
    }
    public function subTotal()
    {
        $carrito= \Session::get('carrito');
        $total=0;
        foreach($carrito as $item)
        {
            $total+= $item->precio * $item->cantidad;
        }
        return $total;
    }
    public function comision()
    {
        $carrito= \Session::get('carrito');
        $comision=0;
        $aux_prov = array();
        foreach($carrito as $item)
        {
            $aux_array = array('proveedores' => $item->nombre_comercial, 'comision' => $item->comision);
            array_push($aux_prov, $aux_array);
        }

        $duplicates = array_map("unserialize", array_unique(array_map("serialize", $aux_prov)));
        foreach ($duplicates as $item) 
        {
            $comision += $item['comision'];
        }
        return $comision;
    }
    public function total()
    {
        $carrito= \Session::get('carrito');
        $total=0;
        $comicion=0;
        $aux_prov = array();
        foreach($carrito as $item)
        {
            $total+= $item->precio * $item->cantidad;
            $aux_array = array('proveedores' => $item->nombre_comercial, 'comision' => $item->comision);
            array_push($aux_prov, $aux_array);
        }

        $duplicates = array_map("unserialize", array_unique(array_map("serialize", $aux_prov)));
        foreach ($duplicates as $item) 
        {
            $comicion += $item['comision'];
        }
        return $total+$comicion;
    }
}
