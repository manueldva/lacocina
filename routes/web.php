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
/*
Route::get('/', function () {
    return view('publico');
});
*/

/*Route::get('/', function () {
    return redirect()->route('publico');
});*/

Route::get('/', function () {
    return redirect()->route('home');
});


//Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();

//Route::get('/publico', 'PublicoController@publico')->name('publico');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vencimientos', 'HomeController@mostrarVencimientos')->name('vencimientos');

Route::resource('manageusers', 'ManageuserController');
route::get('/showSetting/{id}',		'ManageuserController@showSetting')->name('showSetting');
route::put('/setting/{id}',		'ManageuserController@setting')->name('setting');

Route::resource('roles', 'RoleController');

Route::resource('clientes', 'ClienteController');
Route::get('clientes/{cliente}/cargarviandas', 'ClienteController@cargarViandas')->name('clientes.cargarviandas');
// Ruta para almacenar los datos enviados desde el formulario
Route::post('clientes/{cliente}/guardarviandas', 'ClienteController@guardarViandas')->name('clientes.guardarviandas');
Route::post('clientes/{cliente}/ventas/{venta}', 'ClienteController@eliminar')->name('clientes.ventas.eliminar');
// Rutas
Route::get('/ventasDelCliente/{clienteId}', 'ClienteController@ventasDelCliente')->name('clientes.ventas.delcliente');


Route::resource('viandas', 'ViandaController');
Route::resource('tipocontactos', 'TipocontactoController');
Route::resource('tipopagos', 'TipopagoController');
Route::resource('metodopagos', 'MetodoPagoController');

Route::resource('ventas', 'VentaController');
Route::get('clienteInfo/{clienteId}', 'VentaController@getClienteInfo');
Route::post('/actualizar-entregado', 'VentaController@actualizarEntregado')->name('venta.actualizar_entregado');
Route::get('detallesVenta/{id}', 'VentaController@detallesVenta');

Route::resource('informes', 'InformeController');

route::get('/print1/{cliente}/{fechadesde}/{fechahasta}',		'InformeController@print1')->name('print1');


