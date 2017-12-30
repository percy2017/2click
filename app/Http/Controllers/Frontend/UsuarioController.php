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
class UsuarioController extends Controller
{
	function index()
	{
		$productos = DB::table('productos')
					->join('proveedores','proveedores.id','=','productos.proveedor_id')
					->join('categorias','categorias.id','=','productos.categoria_id')
					->select('productos.id','productos.imagen','productos.nombre','productos.descripcion','productos.precio','productos.cantidad','proveedores.nombre_comercial','proveedores.logo')
					->where([['proveedores.habilitado','=',1],['productos.habilitado','=',1],['proveedores.precio','>=',config('app.min_comision')]])
					->orderBy('productos.updated_at','desc')
					->get();
		$catalogos = Categoria::all();
		//return $productos;
		if(Auth::check())
	    {
	    	
	    	$notificaciones = Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->orderBy('created_at','desc')->get();
	    	//return $catalogos;
	    	return view('frontend.index',compact('notificaciones','productos','catalogos'));
	    }else
	    {
	    	// return 'hola';
	    	return view('frontend.index',compact('productos','catalogos'));
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
		$notificaciones = Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->orderBy('created_at','desc')->get();
	    return view('frontend.perfil',compact('notificaciones','lugares'));	
	}
	function catalogo(Request $request)
	{
		return $request;
	}
	function perfil_editar()
	{
		$localidades = Localidad::all(); 
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

		return redirect('/perfil');
	}
    
}
