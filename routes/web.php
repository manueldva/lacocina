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
Route::get('/clientes/{cliente}/ventas/pdf', 'ClienteController@generatePDF')->name('clientes.ventas.pdf');

Route::resource('viandas', 'ViandaController');
Route::resource('tipocontactos', 'TipocontactoController');
Route::resource('tipopagos', 'TipopagoController');
Route::resource('metodopagos', 'MetodoPagoController');
/*
Route::resource('tipoantecedentemedicos', 'TipoantecedentemedicoController');
Route::resource('antecedentemedicos', 'AntecedentemedicoController');
Route::resource('calles', 'CalleController');
Route::resource('barrios', 'BarrioController');
Route::resource('dias', 'DiaController');
Route::resource('tipoclientes', 'TipoclienteController');
*/

