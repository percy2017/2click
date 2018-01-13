<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rol;
use App\Permiso;
use App\Notificacion;
use App\Producto;
use App\Proveedor;
use App\Categoria;
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $notificaciones;
    public function __construct()
    {
        $this->middleware(function ($request, $next) 
        {
            $rol = Rol::where('id', Auth::user()->rol_id)->first();
            $permisos = Permiso::where('rol_id',$rol->id)->where('ruta','admin/productos')->first();
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
        $productos =  DB::table('productos')
                        ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
                        ->join('proveedores', 'proveedores.id','=','productos.proveedor_id')
                        ->select('productos.id', 'productos.imagen', 'productos.nombre' ,'productos.descripcion', 'productos.cantidad', 'productos.precio' ,'productos.habilitado','productos.updated_at', 'categorias.nombre as categoria','proveedores.nombre_comercial')
                        ->orderBy('productos.updated_at', 'desc')
                        ->where('proveedores.user_id', '=', Auth::user()->id)
                        ->paginate(config('app.paginacion'));
        $notificaciones = $this->notificaciones;
        return view('backend.productos.index',compact('productos', 'notificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categorias = Categoria::orderBy('created_at','desc')->get();
        $negocios = Proveedor::where('user_id','=',Auth::user()->id)->orderBy('created_at','desc')->get();
        $notificaciones = $this->notificaciones;
        // return $negocios;
        return view('backend.productos.create',compact('negocios','notificaciones','categorias'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'proveedor_id' => $request->proveedor_id,
            'categoria_id' => $request->categoria_id,
            'habilitado' => $request->habilitado ? 1 : 0,
            'imagen' => $request->imagen ? $request->imagen->getClientOriginalName() : 'default.png'
        ]);
        if($request->imagen)
        {
            \Storage::disk('productos')->put($request->imagen->getClientOriginalName(), \File::get($request->imagen));
        }

        // $notificacion = Notificacion::create([
        //     'mensaje' => $producto->nombre.', Agregado a tu menu',
        //     'ruta' => '/admin/productos',
        //     'user_id' => Auth::user()->id
        // ]);
        return redirect('admin/productos')->with('mensaje_info', $producto->nombre.', creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::where('id',$id)->first();
        $categorias = Categoria::orderBy('created_at','desc')->get();
        $notificaciones = $this->notificaciones;
        $negocios = Proveedor::where('user_id','=',Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('backend.productos.edit',compact('producto','notificaciones','categorias','negocios'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::where('id',$id)->first();
        $producto->nombre = $request->nombre;
        $producto->categoria_id = $request->categoria_id;
        $producto->proveedor_id = $request->proveedor_id;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->cantidad = $request->cantidad;
        $producto->habilitado = $request->habilitado ? 1 : 0;
        if($request->imagen)
        {
            \Storage::disk('productos')->put($request->imagen->getClientOriginalName(), \File::get($request->imagen));
            $producto->imagen = $request->imagen->getClientOriginalName();
        }
        
        $producto->save();

        return redirect('/admin/productos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
