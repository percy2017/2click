<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rol;
use App\Permiso;
use App\Notificacion;
use App\Mensajero;
use App\User;
use App\Vehiculo;

class MensajeroController extends Controller
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
            $permisos = Permiso::where('rol_id',$rol->id)->where('ruta','admin/mensajeros')->first();
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
        $mensajeros = DB::table('mensajeros')
                        ->join('vehiculos','vehiculos.id','=','mensajeros.vehiculo_id')
                        ->join('users','users.id','=','mensajeros.user_id')
                        ->select('mensajeros.id','mensajeros.alias','users.name','users.whatsapp', 'vehiculos.nombre as vehiculo', 'mensajeros.habilitado','mensajeros.created_at')
                        ->orderBy('mensajeros.created_at','desc')
                        ->get();
        $notificaciones = $this->notificaciones;
        // return $mensajeros;
        return view('backend.mensajeros.index',compact('mensajeros','notificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $users = User::where('habilitado','=',1)->get();
        $users = DB::table('users')
                    ->join('roles','roles.id','=','users.rol_id')
                    ->select('users.id','users.name','roles.nombre')
                    ->where('users.habilitado','=',1)
                    ->get();
        $vehiculos = Vehiculo::all();
        $notificaciones = $this->notificaciones;

        return view('backend.mensajeros.create',compact('users','vehiculos','notificaciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Mensajero::create([
            'alias' => $request->alias,
            'user_id' => $request->user_id,
            'vehiculo_id' => $request->vehiculo_id 
        ]);

        return redirect('admin/mensajeros');
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
        //
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
        //
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
