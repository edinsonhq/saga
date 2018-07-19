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


// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', 'LoginController@index');

Route::get('/','ActividadController@index');


Route::get('listado/',array(
	'as'	=>'actividad.index',
	'uses'	=>'ActividadController@index',
));

Route::post('importExcel', 'ActividadController@importExcel');

Route::get('actividad/',array(
	'as'	=>'actividad.index',
	'uses'	=>'ActividadController@index',
));

Route::get('actividad/export/{type}',array(
	'as' => 'actividad.export',
	'uses'	=>'ActividadController@export',
));


Route::get('actividad/formImport',array(
	'as'	=>'actividad.formImport',
	'uses'	=>'ActividadController@formImport',
));


// Route::get('actividad/sendToNavego/{id}/{email}','ActividadController@sendToNavego');

Route::get('actividad/sendToNavego/id/{id}/email/{email}',array(
	'as'	=>'actividad.sendToNavego',
	'uses'	=>'ActividadController@sendToNavego',
));
// Route::post('actividad/sendToNavego/','ActividadController@sendToNavego');



// echo "hola";

Route::get('getActividades',array(
	'as'	=>'getActividades',
	'uses'	=>'ActividadController@getActividades',
));


Route::get('getEmpleadoDatos/{id}',array(
	'as'	=>'getEmpleadoDatos',
	'uses'	=>'ActividadController@getEmpleadoDatos',
));























Route::post('autenticar',array(
	'as'	=>'autenticar',
	'uses'	=>'LoginController@autenticar',
));

Route::get('login',array(
	'as'	=>'login',
	'uses'	=>'LoginController@index',
));

Route::post('logout',array(
	'as'	=>'logout',
	'uses'	=>'LoginController@logout',
));


Route::get('register/',array(
	'as'	=>'registro.create',
	'uses'	=>'RegistroController@create',
));

Route::post('register/',array(
	'as'	=>'register',
	'uses'	=>'RegistroController@store',
));



 Route::get('/home', 'HomeController@index')->name('home');

// Route::get('Login/',array(
// 	'as'	=>'Login.index',
// 	'uses'	=>'LoginController@index',
// ));

// Route::get('user/create','UserController@create');





http://localhost:8000/actividad/sendToNavego/id/5/email/null