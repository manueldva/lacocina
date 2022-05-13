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



Route::resource('establecimientos', 'EstablecimientoController');
Route::resource('clientes', 'ClienteController');
Route::resource('planes', 'PlanController');
Route::resource('tiporepeticiones', 'TiporepeticionesController');
Route::resource('ejercicios', 'EjercicioController');

//Route::post('delete/{id}', 'ManageuserController@delete');