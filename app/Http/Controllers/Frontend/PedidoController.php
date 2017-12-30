<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notificacion;
use App\Lugar;
use App\pagos;
use App\Referencia;
use App\Pedido;
use App\Cupon;
class PedidoController extends Controller
{
	public function __construct()
    {
    	if(!\Session::has('carrito')) \Session::put('carrito',array());   
    }
    public function index()
    {
    	$lugares = Lugar::where('user_id',Auth::user()->id)->get();
        $referencias = Referencia::all();
        $cupon = Cupon::where('habilitado',1)->first();
    	$notificaciones = Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->orderBy('created_at','desc')->get();

        $cantProductos = $this->cantProductos();
        $cantProveedores = $this->cantProveedores();
        $total = $this->total();
    	return view('frontend.pedido',compact('notificaciones','lugares','referencias','cantProductos','cantProveedores','total','cupon'));
    }
    public function guardar(Request $request)
    {
        $pedido = Pedido::create([
            'cupon_id' => $request->cupon_id,
            'estado_id' => 1,
            'pago_id' => 1,
            'subTotal' => $this->subTotal(),
            'comision' => $this->comision(),
            'total' => $this->total(),
            'lugar_id' => $request->lugar_id
        ]);
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
            $comicion += $item['comision'];
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
