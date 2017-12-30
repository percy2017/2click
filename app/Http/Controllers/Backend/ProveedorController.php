<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rol;
use App\User;
use App\Permiso;
use App\Notificacion;
use App\Proveedor;
use App\Tipo;
class ProveedorController extends Controller
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
            $permisos = Permiso::where('rol_id',$rol->id)->where('ruta','admin/proveedores')->first();
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
        //$proveedores = Proveedor::where('user_id', Auth::user()->id)->paginate(config('app.paginacion'));
        //return $proveedores;
        $proveedores = DB::table('proveedores')
                        ->join('tipos','tipos.id','=','proveedores.tipo_id')
                        ->select('proveedores.id','proveedores.nombre_comercial','proveedores.logo','proveedores.direccion','proveedores.whatsapp','proveedores.habilitado','proveedores.created_at','tipos.nombre')
                        ->orderBy('proveedores.created_at','desc')
                        ->get();
        $notificaciones = $this->notificaciones;
        
        return view('backend.proveedores.index', compact('proveedores', 'notificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notificaciones = $this->notificaciones;
        $tipos = Tipo::all();
        return view('backend.proveedores.create', compact('notificaciones','tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        Proveedor::create([
            'nombre_comercial' => $request->nombre_comercial,
            'direccion' => $request->direccion,
            'whatsapp' => $request->whatsapp,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'habilitado' => $request->habilitado ? 1 : 0,
            'logo' => $request->logo ? $request->logo->getClientOriginalName() : 'default.png',
            'user_id' => Auth::user()->id,
            'tipo_id' => $request->tipo_id
        ]);
        
        if($request->logo)
        {
            \Storage::disk('proveedores')->put($request->logo->getClientOriginalName(), \File::get($request->logo));
        }

       Notificacion::create([
            'mensaje' => 'Felicidades creaste un negocio.!',
            'ruta' => '/admin/proveedores',
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('proveedores.index');
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
        $proveedor = Proveedor::where('id',$id)->first();
        $notificaciones = $this->notificaciones;
        $tipos = Tipo::all();
        // return $proveedor;
        return view('backend.proveedores.edit', compact('notificaciones','tipos','proveedor'));

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
        $proveedor = Proveedor::where('id',$id)->first();
        $proveedor->nombre_comercial = $request->nombre_comercial;
        $proveedor->direccion = $request->direccion;
        $proveedor->whatsapp = $request->whatsapp;
        $proveedor->latitud = $request->latitud;
        $proveedor->longitud = $request->longitud;
        $proveedor->habilitado = $request->habilitado ? 1 : 0;
        $proveedor->tipo_id = $request->tipo_id;
        if($request->logo)
        {
            \Storage::disk('proveedores')->put($request->logo->getClientOriginalName(), \File::get($request->logo));
            $proveedor->logo = $request->logo->getClientOriginalName();

        }
        $proveedor->save();
        return redirect('/admin/proveedores');
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
