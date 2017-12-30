<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

//login socialite
Route::get('auth/{provider}', 'Backend\SocialAuthController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'Backend\SocialAuthController@handleProviderCallback');

//rutas usuarios frontend
Route::get('/', 'Frontend\UsuarioController@index')->name('index');
Route::get('/registro', 'Frontend\UsuarioController@create')->name('registro');
Route::post('/guardar', 'Frontend\UsuarioController@store')->name('guardar');
Route::get('/catalogo', 'Frontend\UsuarioController@catalogo')->name('catalogo');

//carrito
Route::get('/carrito/agregar/{id}/{cant}', 'Frontend\CarritoController@agregar')->name('carrito.agregar');
Route::get('/carrito/vaciar', 'Frontend\CarritoController@vaciar')->name('carrito.vaciar');
Route::get('/carrito', 'Frontend\CarritoController@ver')->name('carrito.ver');
Route::get('/carrito/cantidad', 'Frontend\CarritoController@cantProductos')->name('carrito.cantidad');
Route::get('/carrito/editar/{id}/{cant}', 'Frontend\CarritoController@editar')->name('carrito.editar');
Route::get('/carrito/eliminar/{id}', 'Frontend\CarritoController@eliminar')->name('carrito.eliminar');

//pedidos
Route::group(['middleware' => 'auth'], function()
{

    Route::get('/perfil', 'Frontend\UsuarioController@perfil')->name('perfil');
    Route::get('/perfil/editar', 'Frontend\UsuarioController@perfil_editar')->name('perfil.editar');
    Route::post('/perfil/actualizar/', 'Frontend\UsuarioController@perfil_actualizar')->name('perfil.actualizar');
    
    Route::get('/pedido', 'Frontend\PedidoController@index')->name('pedido.index');
    Route::post('/pedido/enviar', 'Frontend\PedidoController@enviar')->name('pedido.enviar');

    //mapas
    Route::post('/mapa/guardar', 'Frontend\MapaController@guardar')->name('mapa.guardar');
});


Route::get('/denegado', function () 
{
    $notificaciones = App\Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->get();
    return view('frontend.denegado',compact('notificaciones'));
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function()
{
    Route::get('/', function () {
    	$rol = App\Rol::where('id',Auth::user()->rol_id)->first();
    	$permisos = App\Permiso::where('rol_id',$rol->id)->where('ruta',Request::path())->first();
    	if($permisos)
    	{
            $notificaciones = App\Notificacion::where('user_id', Auth::user()->id)->where('visto',0)->get();
    		return view('backend.index',compact('notificaciones'));
    	}else
    	{
    		return redirect('/denegado');
    	}
	});
	Route::resource('usuarios', 'Backend\UsuarioController');
	Route::resource('roles', 'Backend\RoleController');
	Route::resource('permisos', 'Backend\PermisoController');
	Route::resource('notificaciones', 'Backend\NotificacionController');
    Route::resource('localidades', 'Backend\LocalidadController');
    Route::resource('lugares', 'Backend\LugarController');
    Route::resource('categorias', 'Backend\CategoriaController');
    Route::resource('productos', 'Backend\ProductoController');
    Route::resource('pagos', 'Backend\PagoController');
    Route::resource('estados', 'Backend\EstadoController');
    Route::resource('cupones', 'Backend\CuponController');
    Route::resource('referencias', 'Backend\ReferenciaController');
    Route::resource('tipos', 'Backend\TipoController');
    Route::resource('proveedores', 'Backend\ProveedorController');

    Route::get('/pedidos/proveedores', 'Backend\PedidoController@proveedores')->name('pedidos.proveedores');
    Route::get('/pedidos/comision/{id}/{comision}', 'Backend\PedidoController@comision_editar')->name('comision.editar');
});

// errores
Route::get('/error',function() {
   abort(401) ;
});
Route::get('/error',function() {
   abort(404) ;
});
Route::get('/error',function() {
   abort(500) ;
});
Route::get('/error',function() {
   abort(503) ;
});