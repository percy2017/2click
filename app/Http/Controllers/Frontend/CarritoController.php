<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notificacion;
class CarritoController extends Controller
{
    public function __construct()
    {
    	if(!\Session::has('carrito')) \Session::put('carrito',array());   
    }
    public function ver()
    {
        $carrito= \Session::get('carrito');
        $cantProveedores = $this->cantProveedores();
        $cantProductos = $this->cantProductos();
        $subTotal = $this->subTotal();
        $total = $this->total();
        if(Auth::check())
        {   
            $notificaciones = Notificacion::where('user_id', Auth::user()->id ? Auth::user()->id : 0 )->where('visto',0)->get();
            return view('frontend.carrito',compact('carrito','notificaciones','cantProveedores','cantProductos','subTotal','total'));
        }else
        {
            return view('frontend.carrito',compact('carrito','cantProveedores','cantProductos','subTotal','total'));
        }
    	

    	
    }
    public function agregar($id, $cant)
    {
    	$producto = DB::table('productos')
        ->join('proveedores', 'productos.proveedor_id', '=', 'proveedores.id')
        ->select('productos.id','productos.nombre','productos.descripcion','productos.imagen','productos.precio','productos.cantidad', 'productos.cantidad as cantDisponible', 'proveedores.id as idP','proveedores.nombre_comercial', 'proveedores.precio as comision')
        ->where('productos.id','=',$id)->first();
    	$carrito= \Session::get('carrito');
    	$producto->cantidad = $cant;
        $carrito[$id] = $producto;
    	\Session::put('carrito',$carrito);
    	// return json_encode($producto);
        return $this->cantProductos();
    }
    public function vaciar()
    {
    	\Session::forget('carrito');
    	return 0;
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
    public function editar($idP, $cantidad)
    {
    	$carrito= \Session::get('carrito');

    	$carrito[$idP]->cantidad = $cantidad;
    	\Session::put('carrito',$carrito);
        return $this->cantProductos();
    	// return redirect()->route('carrito');
    }
    public function eliminar($idP)
    {
    	$carrito= \Session::get('carrito');
    	unset($carrito[$idP]);
    	\Session::put('carrito',$carrito);
    	return $this->cantProductos();
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
}
