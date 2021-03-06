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
Route::get('/login', 'LoginController@login_expires');
Route::post('/login', 'LoginController@login');
/* Dashboard */
Route::group(array('before'=>'auth'),function(){
	Route::get('/logout','LoginController@logout');
	Route::get('/dashboard','DashboardController@home');
});
/* Convocatorias */
Route::group(array('prefix'=>'convocatorias','before'=>'auth'),function(){
	Route::get('/','ConvocatoriasController@home');
	Route::get('/create_convocatoria','ConvocatoriasController@render_create_convocatoria');
	Route::post('/submit_create_convocatoria','ConvocatoriasController@submit_create_convocatoria');
	Route::get('/list_convocatoria','ConvocatoriasController@list_convocatorias');
	Route::get('/edit_convocatoria/{id}','ConvocatoriasController@render_edit_convocatoria');
	Route::post('/submit_edit_convocatoria','ConvocatoriasController@submit_edit_convocatoria');
	Route::get('/list_postulantes/{id}','ConvocatoriasController@list_postulantes');
	Route::get('/search_postulantes','ConvocatoriasController@search_postulantes');
	Route::get('/search_convocatorias','ConvocatoriasController@search_convocatorias');
	Route::post('/submit_aprobacion_postulantes','ConvocatoriasController@submit_aprobacion_postulantes');
	Route::get('/view_postulante/{id}','ConvocatoriasController@render_view_postulante');
	Route::post('/submit_disable_convocatoria','ConvocatoriasController@submit_disable_convocatoria');
	Route::post('/submit_enable_convocatoria','ConvocatoriasController@submit_enable_convocatoria');
	Route::get('/list_voluntarios_convocatoria/{id}','ConvocatoriasController@list_voluntarios');
	Route::get('/view_voluntario_convocatoria/{id}','ConvocatoriasController@render_view_voluntario_convocatoria');
	Route::get('/search_voluntarios','ConvocatoriasController@search_voluntarios');
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
	/* Comentarios */
	Route::get('/comentarios_ninos/{id}','EventosController@render_comentarios_ninos');

});
/* Voluntarios */
Route::group(array('prefix'=>'voluntarios','before'=>'auth'),function(){
	Route::get('/','VoluntariosController@home');
	Route::get('/list_voluntarios','VoluntariosController@list_voluntarios');
	Route::get('/view_voluntario/{id}','VoluntariosController@render_view_voluntario');
	Route::post('/submit_repostulacion','VoluntariosController@submit_repostulacion');
	Route::get('/search_reporte_calificaciones','VoluntariosController@search_reporte_calificaciones');
	Route::get('/list_reporte_calificaciones','VoluntariosController@list_reporte_calificaciones');
	Route::get('/mapa_calor','VoluntariosController@render_mapa_calor');
	Route::post('/submit_asistencia_excel','VoluntariosController@submit_asistencia_excel');
	Route::get('/search_voluntarios','VoluntariosController@search_voluntarios');
});
/* Padrinos */
Route::group(array('prefix'=>'padrinos','before'=>'auth'),function(){
	Route::get('/','PadrinosController@home');
	Route::get('/list_padrinos','PadrinosController@list_padrinos');
	Route::get('/search_padrino','PadrinosController@search_padrino');
	Route::get('/edit_padrino/{id}','PadrinosController@render_edit_padrino');
	Route::post('/submit_edit_padrino','PadrinosController@submit_edit_padrino');
	Route::post('/submit_disable_padrino','PadrinosController@submit_disable_padrino');
	Route::post('/submit_enable_padrino','PadrinosController@submit_enable_padrino');
	Route::get('/list_prepadrinos','PadrinosController@list_prepadrinos');
	Route::get('/edit_prepadrino/{id}','PadrinosController@render_edit_prepadrino');
	Route::post('/submit_aprove_prepadrino','PadrinosController@submit_aprove_prepadrino');
	Route::post('/aprobar_prepadrino_ajax','PadrinosController@aprobar_prepadrino_ajax');
	Route::get('/view_calendario_pagos','PadrinosController@render_view_calendario_pagos');
	Route::get('/list_registrar_pagos','PadrinosController@list_registrar_pagos');
	Route::post('/submit_registrar_pagos','PadrinosController@submit_registrar_pagos');
	/* Reporte a Padrinos */
	Route::get('/create_reporte_padrinos','PadrinosController@render_create_reporte_padrinos');
	Route::post('/submit_create_reporte_padrinos','PadrinosController@submit_create_reporte_padrinos');
	Route::get('/list_reporte_padrinos','PadrinosController@list_reporte_padrinos');
	Route::get('/search_reporte_padrinos','PadrinosController@search_reporte_padrinos');
	Route::post('/descargar_reporte_padrino','PadrinosController@submit_descargar_reporte_padrino');
	Route::get('/list_mis_reportes','PadrinosController@list_mis_reportes');
	Route::get('/search_mis_reportes','PadrinosController@search_mis_reportes');
	Route::get('/reporte_pagos_padrinos','PadrinosController@render_reporte_pagos_padrinos');
	Route::post('/submit_reporte_pagos_padrinos','PadrinosController@submit_reporte_pagos_padrinos');
	Route::get('/list_aprobar_pagos','PadrinosController@list_aprobar_pagos');
	Route::post('/aprobar_pago_ajax','PadrinosController@aprobar_pago_ajax');
	Route::get('/view_pago/{id}','PadrinosController@render_view_pago');
	Route::post('/submit_aprove_pago','PadrinosController@submit_aprove_pago');	
	Route::post('/submit_rechazar_pago','PadrinosController@submit_rechazar_pago');
	Route::post('payment', array(
	    'as' => 'payment',
	    'uses' => 'IndexController@postPayment',
	));

	// this is after make the payment, PayPal redirect back to your site
	Route::get('payment/status', array(
	    'as' => 'payment.status',
	    'uses' => 'IndexController@getPaymentStatus',
	));
});
/* Colegios */
Route::group(array('prefix'=>'colegios','before'=>'auth'),function(){
	Route::get('/','ColegiosController@home');
	Route::get('/create_colegio','ColegiosController@render_create_colegio');
	Route::post('/submit_create_colegio','ColegiosController@submit_create_colegio');
	Route::get('/list_colegios','ColegiosController@list_colegios');
	Route::get('/search_colegio','ColegiosController@search_colegio');
	Route::get('/edit_colegio/{id}','ColegiosController@render_edit_colegio');
	Route::post('/submit_edit_colegio','ColegiosController@submit_edit_colegio');
	Route::post('/submit_disable_colegio','ColegiosController@submit_disable_colegio');
	Route::post('/submit_enable_colegio','ColegiosController@submit_enable_colegio');
	Route::get('/list_precolegios','ColegiosController@list_precolegios');
	Route::get('/edit_precolegio/{id}','ColegiosController@render_edit_precolegio');
	Route::post('/submit_aprove_precolegio','ColegiosController@submit_aprove_precolegio');
});

/*Niños*/
Route::group(array('prefix'=>'ninhos','before'=>'auth'),function(){
	Route::get('/','NinhoController@home');
	Route::get('/create_ninho','NinhoController@render_create_ninho');
	Route::post('/submit_create_ninho','NinhoController@submit_create_ninho');
	Route::get('/list_ninhos','NinhoController@list_ninhos');
	Route::get('/search_ninho','NinhoController@search_ninho');

	Route::get('/edit_ninho/{id}','NinhoController@render_edit_ninho');
	Route::post('/submit_edit_ninho','NinhoController@submit_edit_ninho');
	Route::post('/submit_disable_ninho','NinhoController@submit_disable_ninho');
	Route::post('/submit_enable_ninho','NinhoController@submit_enable_ninho');
});

/* Proyectos */
Route::group(array('prefix'=>'concursos','before'=>'auth'),function(){
	Route::get('/','ConcursosController@home');
	Route::get('/search_concurso','ConcursosController@search_concurso');
	Route::get('/list_concursos','ConcursosController@list_concursos');
	Route::get('/create_concurso','ConcursosController@render_create_concurso');
	Route::post('/submit_create_concurso','ConcursosController@submit_create_concurso');
	Route::get('/upload_file/{id}','ConcursosController@render_upload_file');
	Route::post('/submit_upload_file','ConcursosController@submit_upload_file');
	Route::post('/submit_delete_file','ConcursosController@submit_delete_file');	
	Route::post('/descargar_documento','ConcursosController@submit_descargar_documento');
	Route::post('/fase_register_ajax','ConcursosController@fase_register_ajax');
	Route::post('/fase_delete_ajax','ConcursosController@fase_delete_ajax');
	Route::get('/fases_concurso/{id}','ConcursosController@render_fases_concurso');
	Route::get('/edit_concurso/{id}','ConcursosController@render_edit_concurso');
	Route::post('/submit_edit_concurso','ConcursosController@submit_edit_concurso');
	Route::post('/submit_disable_concurso','ConcursosController@submit_disable_concurso');
	Route::get('/search_proyecto','ConcursosController@search_proyecto');
	Route::get('/list_proyectos','ConcursosController@list_proyectos');
	Route::get('/create_proyecto','ConcursosController@render_create_proyecto');
	Route::post('/submit_create_proyecto','ConcursosController@submit_create_proyecto');
	Route::get('/edit_proyecto/{id}','ConcursosController@render_edit_proyecto');
	Route::post('/submit_edit_proyecto','ConcursosController@submit_edit_proyecto');
	Route::post('/submit_disable_proyecto','ConcursosController@submit_disable_proyecto');
	Route::get('/upload_file_proyecto/{id}','ConcursosController@render_upload_file_proyecto');
	Route::post('/submit_upload_file_proyecto','ConcursosController@submit_upload_file_proyecto');
	Route::post('/submit_delete_file_proyecto','ConcursosController@submit_delete_file_proyecto');
	Route::post('/detalle_register_ajax','ConcursosController@detalle_register_ajax');
	Route::post('/detalle_delete_ajax','ConcursosController@detalle_delete_ajax');
	Route::get('/detalle_proyecto/{id}','ConcursosController@render_detalle_proyecto');	
	Route::post('/edit_detalle_ajax','ConcursosController@edit_detalle_ajax');
	Route::get('/list_proyectos_asociados/{id}','ConcursosController@render_list_proyectos_asociados');
	Route::post('/submit_aprove_proyecto','ConcursosController@submit_aprove_proyecto');
	Route::post('/get_proyectos_concursos','ConcursosController@get_proyectos_concursos');
	Route::post('/get_proyecto_aprobado','ConcursosController@get_proyecto_aprobado');
});
/* Users */
Route::group(array('prefix'=>'user', 'before'=>'auth'),function(){
	Route::get('/create_user','UserController@render_create_user');
	Route::post('/submit_create_user','UserController@submit_create_user');
	Route::get('/list_users','UserController@list_users');
	Route::get('/search_user','UserController@search_user');
	Route::get('/edit_user/{id}','UserController@render_edit_user');
	Route::post('/submit_edit_user','UserController@submit_edit_user');
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
	Route::post('/submit_edit_perfil','SistemaController@submit_edit_perfil');
	Route::post('/submit_disable_perfil','SistemaController@submit_disable_perfil');
	Route::get('/list_logs','SistemaController@list_logs');
	Route::get('/search_logs','SistemaController@search_logs');
});
// Route group for API versioning
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::post('/sign_in', 'api\v1\SessionController@sign_in');
    Route::post('/prepadrinos', 'api\v1\PrepadrinosController@store');
    Route::post('/empresas', 'api\v1\EmpresasController@store');
    Route::post('/postulantes', 'api\v1\PostulantesController@store');
    Route::post('/precolegios', 'api\v1\PrecolegiosController@store');
    Route::post('/recover_password', 'api\v1\UserController@recover_password');
});

Route::group(array('prefix' => 'api/v1', 'before' => 'api.auth'), function()
{
    Route::put('change_password', 'api\v1\UserController@change_password');
    Route::get('sessions', 'api\v1\EventosController@sesiones');
    Route::get('children', 'api\v1\NinhosController@index');
    Route::get('locations', 'api\v1\LocationController@locations');
    Route::get('users', 'api\v1\UserController@users');
    Route::post('meeting_points', 'api\v1\MeetingPointController@meeting_points');
    Route::post('reapply', 'api\v1\VolunteerController@reapply');
    Route::post('payment', 'api\v1\SponsorController@payment');
    Route::post('roll_call', 'api\v1\VolunteerController@roll_call');
    Route::get('payment_calendar', 'api\v1\SponsorController@payment_calendar');
    Route::post('attendance_children/{attendance_children_id}/comments', 'api\v1\NinhosController@comment');
    Route::get('documents', 'api\v1\DocumentosController@index');
    Route::post('documents/{document_id}/visualizations', 'api\v1\DocumentosController@register_visualization');
    Route::get('children/{id}', 'api\v1\NinhosController@show');
    Route::get('activity_reports', 'api\v1\SponsorController@activity_reports');
    Route::post('verify_payment', 'api\v1\PayPalController@verify');
    Route::post('set_uuid', 'api\v1\SessionController@set_uuid');
    Route::post('clear_uuid', 'api\v1\SessionController@clear_uuid');
    Route::post('set_gcm_token', 'api\v1\SessionController@set_gcm_token');
    Route::post('clear_gcm_token', 'api\v1\SessionController@clear_gcm_token');
    Route::post('push_settings', 'api\v1\PushSettingsController@push_settings');
});

/* Rutas para el juego */
Route::group(array('prefix' => 'game'), function()
{
    Route::get('player', 'api\juego\JuegoController@player');
    Route::post('player', 'api\juego\JuegoController@create_player');
    Route::post('friends/score', 'api\juego\JuegoController@friendsScore');
    Route::get('level/graph', 'api\juego\JuegoController@levelGraph');
    Route::post('level/clear', 'api\juego\JuegoController@levelClear');
    Route::post('level/defeat', 'api\juego\JuegoController@levelDefeat');
    Route::get('pu', 'api\juego\JuegoController@pu');
    Route::post('level/continue', 'api\juego\JuegoController@levelContinue');
    Route::post('level/purchase', 'api\juego\JuegoController@levelPurchase');
    Route::post('pu/purchase', 'api\juego\JuegoController@puPurchase');
    Route::post('friends/helpNeeded', 'api\juego\JuegoController@friendsHelpNeeded');
    Route::post('friends/help', 'api\juego\JuegoController@friendsHelp');
});

/* Empresa */
Route::group(array('prefix'=>'empresas','before'=>'auth'),function(){
	Route::get('/','EmpresasController@home');
	Route::get('/list_empresas','EmpresasController@list_empresas');
	Route::get('/search_empresa','EmpresasController@search_empresa');
	Route::get('/edit_empresa/{id}','EmpresasController@render_edit_empresa');
	Route::post('/submit_disable_empresa','EmpresasController@submit_disable_empresa');
	Route::post('/submit_enable_empresa','EmpresasController@submit_enable_empresa');
	Route::post('/submit_edit_empresa','EmpresasController@submit_edit_empresa');
});