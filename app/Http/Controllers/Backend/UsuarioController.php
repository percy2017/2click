<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\Rol;
use App\Permiso;
use App\Notificacion;
use App\Localidad;
class UsuarioController extends Controller
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
            $permisos = Permiso::where('rol_id',$rol->id)->where('ruta','admin/usuarios')->first();
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
        $usuarios = DB::table('users')
        ->join('roles', 'users.rol_id', '=', 'roles.id')
        ->join('localidades', 'users.localidad_id', '=', 'localidades.id')
        ->select('users.id','users.name','users.foto','users.email','users.redsocial', 'users.habilitado','users.created_at','roles.nombre as rol','localidades.nombre as localidad')
        ->orderBy('users.created_at','desc')
        ->paginate(config('app.paginacion'));

        $roles = Rol::all();
        $localidades = Localidad::all();
        $notificaciones = $this->notificaciones;
        return view('backend.usuarios.index',compact('usuarios', 'notificaciones','roles','localidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol_id' => $request->rol_id,
            'localidad_id' => $request->localidad_id
        ]);

       Notificacion::create([
            'mensaje' => $user->name.config('app.mensaje_bienvenida'),
            'ruta' => '/hola',
            'user_id' => $user->id
        ]);
        return redirect('/admin/usuarios');
        // return $request;
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
        // $user = User::where('id',$id)->first();
        $user = DB::table('users')
                    ->join('roles','roles.id','=','users.rol_id')
                    ->join('localidades','localidades.id','=','users.localidad_id')
                    ->select('users.id','roles.nombre as rol','localidades.nombre as localidad','users.name','users.email','users.password','users.habilitado')
                    ->where('users.id','=',$id)
                    ->first();
        // $des = Crypt::decryptString(json_encode($user->password));
        // return $des;
        return json_encode($user);
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
        $user = User::where('id',$request->id)->first();
        $user->rol_id = $request->rol_id;
        $user->localidad_id = $request->localidad_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->habilitado = $request->habilitado ? 1 : 0;
        $user->save();

        return redirect('admin/usuarios');
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

    public function login_admin($id)
    {
        $user = User::where('id','=',$id)->first();
        Auth::login($user);
        return redirect('/');
    }
}
