<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rol;
use App\Permiso;
use App\Notificacion;
use App\Cupon;

class CuponController extends Controller
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
            $permisos = Permiso::where('rol_id',$rol->id)->where('ruta','admin/cupones')->first();
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
        $cupones =  Cupon::all();
        $notificaciones = $this->notificaciones;
        return view('backend.cupones.index',compact('cupones', 'notificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Cupon::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'descuento' => $request->descuento,
            'habilitado' => $request->habilitado ? 1 : 0 
        ]);
        return redirect('admin/cupones');
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
        $cupon = Cupon::where('id',$id)->first();
        
        return json_encode($cupon);
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
        // return $request; 
        $cupon = Cupon::where('id',$request->id)->first();

        $cupon->codigo = $request->codigo;
        $cupon->nombre = $request->nombre;
        $cupon->descripcion = $request->descripcion;
        $cupon->descuento = $request->descuento;
        $cupon->habilitado = $request->habilitado ? 1 : 0;
        $cupon->save();
        return redirect('admin/cupones');
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
