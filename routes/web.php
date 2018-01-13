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
// Route::fallback('BaseController@notFound');

Auth::routes();

//login socialite
Route::get('auth/{provider}', 'Backend\SocialAuthController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'Backend\SocialAuthController@handleProviderCallback');

//rutas usuarios frontend
Route::get('/', 'Frontend\UsuarioController@index')->name('index');
Route::get('/registro', 'Frontend\UsuarioController@create')->name('registro');
Route::post('/guardar', 'Frontend\UsuarioController@store')->name('guardar');
Route::get('/catalogo', 'Frontend\UsuarioController@catalogo')->name('catalogo');

//productos
Route::get('/productos/index/{page?}', 'Frontend\ProductoController@index')->name('productos_index');
Route::get('/productos/buscar/{criterio}/{page?}', 'Frontend\ProductoController@buscar')->name('productos_buscar');
Route::get('/productos/catalogo/{id_categoria}/{page?}', 'Frontend\ProductoController@catalogo')->name('productos_catalogo');
Route::get('/productos/proveedor/{id_proveedor}/{page?}', 'Frontend\ProductoController@proveedor')->name('productos_proveedor');

//carrito
Route::get('/carrito/agregar/{id}/{cant}', 'Frontend\CarritoController@agregar')->name('carrito.agregar');
Route::get('/carrito/vaciar', 'Frontend\CarritoController@vaciar')->name('carrito.vaciar');
Route::get('/carrito', 'Frontend\CarritoController@ver')->name('carrito.ver');
Route::get('/carrito/cantidad', 'Frontend\CarritoController@cantProductos')->name('carrito.cantidad');
Route::get('/carrito/editar/{id}/{cant}', 'Frontend\CarritoController@editar')->name('carrito.editar');
Route::get('/carrito/eliminar/{id}', 'Frontend\CarritoController@eliminar')->name('carrito.eliminar');


Route::group(['middleware' => 'auth'], function()
{

    Route::get('/perfil', 'Frontend\UsuarioController@perfil')->name('perfil');
    Route::get('/perfil/editar', 'Frontend\UsuarioController@perfil_editar')->name('perfil.editar');
    Route::post('/perfil/actualizar/', 'Frontend\UsuarioController@perfil_actualizar')->name('perfil.actualizar');
    
    Route::get('/pedido', 'Frontend\PedidoController@index')->name('pedido.index');
    Route::post('/pedido/guardar', 'Frontend\PedidoController@guardar')->name('pedido.guardar');

    //mapas
    Route::post('/mapa/guardar', 'Frontend\MapaController@guardar')->name('mapa.guardar');

    // mensajeros
    Route::get('/mensajero', 'Frontend\MensajeroController@index')->name('mensajero.index');
    Route::get('/mensajero/productos/{id}', 'Frontend\MensajeroController@carrito')->name('mensajero.productos');
    Route::get('/mensajero/asignar/{id}', 'Frontend\MensajeroController@asignar')->name('mensajero.asignar');
    Route::get('/mensajero/historico', 'Frontend\MensajeroController@historico')->name('mensajero.historico');
    Route::get('/mensajero/mapa/{id}', 'Frontend\MensajeroController@mapa')->name('mensajero.mapa');
    Route::get('/mensajero/pedido/entregar/{id}', 'Frontend\MensajeroController@entregar')->name('mensajero.entregar');

    //notificaciones
    Route::get('/notificaciones', 'Frontend\UsuarioController@notificaciones')->name('notificacion.index');
    Route::get('/notificaciones/ver', 'Frontend\UsuarioController@notificaciones_ver')->name('notificacion.ver');
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
    Route::get('/login/admin/{id}', 'Backend\UsuarioController@login_admin')->name('login.admin');
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
    Route::get('/proveedores/cerrar/{id}', 'Backend\ProveedorController@cerrar')->name('proveedores.cerrar');
    Route::get('/proveedores/abrir/{id}', 'Backend\ProveedorController@abrir')->name('proveedores.abrir');

    Route::resource('mensajeros', 'Backend\MensajeroController');
    Route::resource('vehiculos', 'Backend\VehiculoController');

    //pedidos
    Route::get('/pedidos/proveedores', 'Backend\PedidoController@proveedores')->name('pedidos.proveedores');
    Route::get('/pedidos/comision/{id}/{comision}', 'Backend\PedidoController@comision_editar')->name('comision.editar');
    Route::get('/pedidos/encola', 'Backend\PedidoController@en_cola')->name('pedidos.encola');
    Route::get('/pedidos/carrito/{id}', 'Backend\PedidoController@carrito')->name('pedidos.carrito');
    Route::get('/pedidos/mensajero/{id}', 'Backend\PedidoController@mensajero')->name('pedidos.mensajero');
    Route::get('/pedidos/mensajero/asiganacion/{mensajero_id}/{pedido_id}', 'Backend\PedidoController@asignar_mensajero')->name('pedidos.asignar');
    Route::get('/usuarios/pedidos/{id}', 'Backend\PedidoController@pedidos_usuario')->name('pedidos.usuario');
    Route::get('/pedidos/cancelar/{id}', 'Backend\PedidoController@cancelar')->name('pedidos.cancelar');
    Route::get('/pedidos/historico', 'Backend\PedidoController@historico')->name('pedidos.historico');
    Route::get('/pedidos/mensajeros/all', 'Backend\PedidoController@mensajeros_all')->name('pedidos.mensajeros_all');
    Route::get('/pedidos/items', 'Backend\PedidoController@items')->name('pedidos.items');

    //solicitudes
    Route::get('/solicitudes', 'Backend\SolicitudController@index')->name('solicitudes.index');
    Route::get('/solicitudes/entregar/{id}/{pedido_id}', 'Backend\SolicitudController@entregar')->name('solicitudes.entregar');
    Route::get('/solicitudes/mensajero/{id}', 'Backend\SolicitudController@mensajero')->name('solicitudes.mensajero');

    //ingresos
    Route::get('/ingresos', 'Backend\IngresoController@index')->name('ingresos.index');


    
});

// errores
// Route::get('/error',function() {
//    abort(400) ;
// });
// Route::get('/error',function() {
//    abort(401) ;
// });
// Route::get('/error',function() {
//    abort(403) ;
// });
// Route::get('/error',function() {
//    abort(404) ;
// });
// Route::get('/error',function() {
//    abort(408) ;
// });
// Route::get('/error',function() {
//    abort(500) ;
// });
// Route::get('/error',function() {
//    abort(504) ;
// });