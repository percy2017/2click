<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notificacion;
use App\Referencia;
use App\User;

class ProductoController extends Controller
{
    public function index()
	{
		$productos = DB::table('productos')
					->join('proveedores','proveedores.id','=','productos.proveedor_id')
					->join('categorias','categorias.id','=','productos.categoria_id')
					->select('productos.id','productos.imagen','productos.nombre','productos.descripcion','productos.precio','productos.cantidad','proveedores.nombre_comercial','proveedores.logo','proveedores.direccion','categorias.nombre as categoria')
					->where([['proveedores.habilitado','=',1],['productos.habilitado','=',1],['proveedores.precio','>=',config('app.min_comision')],['productos.cantidad','>',0]])
					->orderBy('productos.updated_at','desc')
					->paginate(config('app.paginacion'));
		return view('frontend.productos.index',compact('productos'));
	}
	public function buscar($criterio)
	{
		$productos = DB::table('productos')
					->join('proveedores','proveedores.id','=','productos.proveedor_id')
					->join('categorias','categorias.id','=','productos.categoria_id')
					->select('productos.id','productos.imagen','productos.nombre','productos.descripcion','productos.precio','productos.cantidad','proveedores.nombre_comercial','proveedores.logo','proveedores.direccion', 'categorias.nombre as categoria')
					->where([['proveedores.habilitado','=',1],['productos.habilitado','=',1],['proveedores.precio','>=',config('app.min_comision')],['productos.cantidad','>',0],['productos.nombre','like','%'.$criterio.'%']])
					->orWhere('productos.descripcion','like','%'.$criterio.'%')
					->orderBy('productos.updated_at','desc')
					->paginate(config('app.paginacion'));
		return view('frontend.productos.index',compact('productos'));
	}

	public function catalogo($categoria_id)
	{
		$productos = DB::table('productos')
					->join('proveedores','proveedores.id','=','productos.proveedor_id')
					->join('categorias','categorias.id','=','productos.categoria_id')
					->select('productos.id','productos.imagen','productos.nombre','productos.descripcion','productos.precio','productos.cantidad','proveedores.nombre_comercial','proveedores.logo','proveedores.direccion','categorias.nombre as categoria')
					->where([['proveedores.habilitado','=',1],['productos.habilitado','=',1],['proveedores.precio','>=',config('app.min_comision')],['productos.cantidad','>',0],['productos.categoria_id','like',$categoria_id]])
					->orderBy('productos.updated_at','desc')
					->paginate(config('app.paginacion'));

		return view('frontend.productos.catalogo',compact('productos'));
	}

	public function proveedor($proveedor_id)
	{
		$productos = DB::table('productos')
					->join('proveedores','proveedores.id','=','productos.proveedor_id')
					->join('categorias','categorias.id','=','productos.categoria_id')
					->select('productos.id','productos.imagen','productos.nombre','productos.descripcion','productos.precio','productos.cantidad','proveedores.nombre_comercial','proveedores.logo','proveedores.direccion','categorias.nombre as categoria')
					->where([['proveedores.habilitado','=',1],['productos.habilitado','=',1],['proveedores.precio','>=',config('app.min_comision')],['productos.cantidad','>',0],['productos.proveedor_id','like',$proveedor_id]])
					->orderBy('productos.updated_at','desc')
					->paginate(config('app.paginacion'));

		return view('frontend.productos.proveedor',compact('productos'));
	}

}
