<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notificacion;
use App\Referencia;
use App\User;
use App\Lugar;
use App\Categoria;
use App\Localidad;
use App\Pedido;
use App\Proveedor;
class UsuarioController extends Controller
{
	function index()
	{
		

		$catalogos = Categoria::all();
		$proveedores = Proveedor::all();
		//return $productos;
		if(Auth::check())
	    {
	    	$notificaciones = Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->orderBy('created_at','desc')->get();
	    	//return $catalogos;
	    	return view('frontend.index',compact('notificaciones','catalogos','proveedores'));
	    }else
	    {
	    	// return 'hola';
	    	return view('frontend.index',compact('catalogos','proveedores'));
	    }
	}
	function create()
	{
		$referencias = Referencia::all();
		$localidades = Localidad::all();
		return view('auth.register',compact('referencias','localidades'));
	}
	function store(Request $request)
	{
		// return $request;
		$this->validate($request, [
       		'g-recaptcha-response' =>'required|captcha'
      	]);
      	$user = User::create([
      		'name' => $request->name,
      		'email' => $request->email,
      		'whatsapp' =>$request->whatsapp,
      		'carnet' => $request->carnet,
      		'password' => bcrypt($request->password),
      		'foto' => $request->foto ? $request->foto->getClientOriginalName() : 'default.png',
      		'rol_id' => 1,
      		'localidad_id' => $request->localidad_id

      	]);
      	if($request->foto)
        {
            \Storage::disk('users')->put($request->foto->getClientOriginalName(), \File::get($request->foto));
        }

        Lugar::create([
        	'direccion' => $request->direccion,
        	'latitud' => $request->latitud,
        	'longitud' => $request->longitud,
        	'referencia_id' => $request->referencia_id,
        	'user_id' => $user->id
        ]);

        Notificacion::create([
            'mensaje' => config('app.mensaje_bienvenida'),
            'ruta' => '/hola',
            'user_id' => $user->id
        ]);        

        Auth::login($user);
		return redirect('/');
	}

	function perfil()
	{
		$lugares = Lugar::where('user_id',Auth::user()->id)->get();
		$referencias = Referencia::all();
		$pedidos = DB::table('pedidos')
					->join('lugares','lugares.id','=','pedidos.lugar_id')
					->join('estados','estados.id','=','pedidos.estado_id')
					->select('pedidos.id','pedidos.created_at','estados.nombre','pedidos.total','lugares.direccion')
					->where('lugares.user_id','=',Auth::user()->id)
					->orderBy('pedidos.created_at','desc')
					->get();
		$notificaciones = Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->orderBy('created_at','desc')->get();

		// return $pedidos;
	    return view('frontend.perfil',compact('notificaciones','lugares','pedidos','referencias'));
	    //return redirect()->back();
	}
	function catalogo(Request $request)
	{
		return $request;
	}
	function perfil_editar()
	{
		$localidades = Localidad::where('id','<>','1')->get(); 
		
		$notificaciones = Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->orderBy('created_at','desc')->get();
		return view('frontend.perfil_edit',compact('localidades','notificaciones'));
	}
	function perfil_actualizar(Request $request)
	{
		$user = User::where('id',Auth::user()->id)->first();
		$user->name = $request->name;
		$user->email = $request->email;
		$user->whatsapp = $request->whatsapp;
		$user->carnet = $request->carnet;
		$user->localidad_id = $request->localidad_id;
		if($request->foto)
        {
            \Storage::disk('users')->put($request->foto->getClientOriginalName(), \File::get($request->foto));
            $user->foto = $request->foto->getClientOriginalName();
        }
		$user->save();

		return redirect('/pedido');
	}

	function notificaciones()
	{
		$notificaciones_all = Notificacion::where('user_id', Auth::user()->id)->orderBy('created_at','desc')->paginate(config('app.paginacion'));
		$notificaciones = Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->orderBy('created_at','desc')->get();
		return view('frontend.notificaciones',compact('notificaciones','notificaciones_all'));

	}
    
    function notificaciones_ver()
    {
    	$notificaciones = Notificacion::where([['user_id', Auth::user()->id],['visto','=',0]])->update(['visto' => 1]);;
    }
}
