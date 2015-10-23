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
	/* Eventos */
	Route::get('/create_evento','EventosController@render_create_evento');
	Route::post('/submit_create_evento','EventosController@submit_create_evento');
	Route::get('/list_eventos','EventosController@list_eventos');
	Route::get('/search_evento','EventosController@search_evento');
	Route::get('/edit_evento/{id}','EventosController@render_edit_evento');
	Route::post('/submit_edit_evento','EventosController@submit_edit_evento');
	Route::post('/submit_delete_evento','EventosController@submit_delete_evento');
	Route::get('/upload_file/{id}','EventosController@render_upload_file');
	Route::post('/submit_upload_file','EventosController@submit_upload_file');
	Route::post('/submit_delete_file','EventosController@submit_delete_file');
	/* Toma de asistencia */
	Route::get('/asistencia_evento/{id}','EventosController@render_asistencia_evento');
	Route::post('/submit_asistencia_evento','EventosController@submit_asistencia_evento');
	/* Mis Eventos */
	Route::get('/mis_eventos','EventosController@render_mis_eventos');
	Route::post('/mis_eventos_ajax','EventosController@mis_eventos_ajax');
	Route::get('/mis_eventos/{fecha}','EventosController@render_mis_eventos_fecha');
	Route::get('/ver_evento/{id}','EventosController@render_ver_evento');
	Route::post('/descargar_documento','EventosController@submit_descargar_documento');
	Route::get('/registrar_comentario/{id}','EventosController@render_registrar_comentario');
	Route::post('/submit_registrar_comentario','EventosController@submit_registrar_comentario');
	/* Puntos de reunión*/
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
	Route::get('/list_padrinos','PadrinosController@list_padrinos');
	Route::get('/search_padrino','PadrinosController@search_padrino');
	Route::get('/edit_padrino/{id}','PadrinosController@render_edit_padrino');
	Route::post('/submit_edit_padrino','PadrinosController@submit_edit_padrino');
});
/* Colegios */
Route::group(array('prefix'=>'colegios','before'=>'auth'),function(){
	Route::get('/','ColegiosController@home');
	Route::get('/create_colegio','ColegiosController@render_create_colegio');
	Route::post('/submit_create_colegio','ColegiosController@submit_create_colegio');
	Route::get('/list_colegios','ColegiosController@list_colegios');
	Route::get('/edit_colegio/{id}','ColegiosController@render_edit_colegio');
	//Route::post('/submit_edit_colegio','ColegiosController@submit_edit_colegio');
	Route::post('/submit_disable_colegio','ColegiosController@submit_disable_colegio');
	Route::post('/submit_enable_colegio','ColegiosController@submit_enable_colegio');
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
    Route::get('sessions', 'api\v1\EventosController@sesiones');
});

/* Rutas para el juego */
Route::group(array('prefix' => 'game'), function()
{
    Route::get('player', 'api\juego\JuegoController@player');
    Route::post('player', 'api\juego\JuegoController@create_player');
    Route::get('friends/score', 'api\juego\JuegoController@friendsScore');
});