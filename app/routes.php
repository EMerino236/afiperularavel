<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', 'HomeController@home');
Route::controller('password', 'RemindersController');
/* Login */
Route::post('/login', 'LoginController@login');
/* Dashboard */
Route::group(array('before'=>'auth'),function(){
	Route::get('/logout','LoginController@logout');
	Route::get('/dashboard','DashboardController@home');
});
/* Convocatorias */
Route::group(array('prefix'=>'convocatorias','before'=>'auth'),function(){
	Route::get('/','ConvocatoriasController@home');
});
/* Eventos */
Route::group(array('prefix'=>'eventos','before'=>'auth'),function(){
	Route::get('/','EventosController@home');
	Route::get('/create_punto_reunion','EventosController@render_create_punto_reunion');
	Route::post('/submit_create_punto_reunion','EventosController@submit_create_punto_reunion');
	Route::get('/list_puntos_reunion','EventosController@list_puntos_reunion');
	Route::get('/list_puntos_reunion_ajax','EventosController@list_puntos_reunion_ajax');
	Route::post('/submit_disable_puntos_reunion_ajax','EventosController@submit_disable_puntos_reunion_ajax');
});
/* Voluntarios */
Route::group(array('prefix'=>'voluntarios','before'=>'auth'),function(){
	Route::get('/','VoluntariosController@home');
});
/* Padrinos */
Route::group(array('prefix'=>'padrinos','before'=>'auth'),function(){
	Route::get('/','PadrinosController@home');
});
/* Colegios */
Route::group(array('prefix'=>'colegios','before'=>'auth'),function(){
	Route::get('/','ColegiosController@home');
});
/* Proyectos */
Route::group(array('prefix'=>'concursos','before'=>'auth'),function(){
	Route::get('/','ConcursosController@home');
});
/* Users */
Route::group(array('prefix'=>'user', 'before'=>'auth'),function(){
	Route::get('/create_user','UserController@render_create_user');
	Route::post('/submit_create_user','UserController@submit_create_user');
	Route::get('/list_users','UserController@list_users');
	Route::get('/search_user','UserController@search_user');
	Route::get('/edit_user/{id}','UserController@render_edit_user');
	//Route::post('/submit_edit_user','UserController@submit_edit_user');
	Route::post('/submit_disable_user','UserController@submit_disable_user');
	Route::post('/submit_enable_user','UserController@submit_enable_user');
	Route::get('/mi_cuenta','UserController@render_mi_cuenta');
	Route::post('/submit_mi_cuenta','UserController@submit_mi_cuenta');
});
/* Sistema */
Route::group(array('prefix'=>'sistema','before'=>'auth'),function(){
	Route::get('/','SistemaController@home');
	Route::get('/create_perfil','SistemaController@render_create_perfil');
	Route::post('/submit_create_perfil','SistemaController@submit_create_perfil');
	Route::get('/list_perfiles','SistemaController@list_perfiles');
	Route::get('/edit_perfil/{id}','SistemaController@render_edit_perfil');
	Route::post('/submit_disable_perfil','SistemaController@submit_disable_perfil');
});
// Route group for API versioning
Route::group(array('prefix' => 'api/v1'), function()
{
    // Route::resource('/users', 'UserWS');
    Route::post('sign_in', 'api\v1\SessionController@sign_in');
});

Route::group(array('prefix' => 'api/v1', 'before' => 'api.auth'), function()
{
    Route::put('change_password', 'api\v1\UserController@change_password');
});