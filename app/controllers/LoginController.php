<?php

class LoginController extends BaseController
{
	public function login()
	{
		// Implemento la reglas para la validacion de los datos
		$rules = array(
					'num_documento' => 'required|min:8',
					'password' => 'required|min:6'
				);
		// Corro la validacion
		$validator = Validator::make(Input::all(), $rules);
		// Si falla la validacion se redirige al login con un mensaje de error
		if($validator->fails()){
			Session::flash('error', 'Ingrese los campos correctamente');
			return Redirect::to('/')->withInput(Input::except('password'));
		}else{
			// Se crea un arreglo de datos para intentar la autenticacion
			$userdata = array(
							'num_documento' => Input::get('num_documento'),
							'password' => Input::get('password')
						);
			// Se intenta autenticar al usuario
			if(Auth::attempt($userdata)){
				// Si la autenticacion es exitosa guardo en la variable de sesión la información del usuario
				Session::put('user',Auth::user());
				$pre_permisos = User::getPermisosPorUsuario(Auth::user()->id)->get();
				$permisos = array();
				foreach($pre_permisos as $pre_permiso)
					$permisos[] = $pre_permiso['nombre'];
				Session::put('permisos',$permisos);
				return Redirect::to('/dashboard');
			}else{
				// Si falla la autenticacion se lo regresa al login con un mensaje de error
				Session::flush();
				Session::flash('error', 'Usuario y/o contraseña incorrectos');
				return Redirect::to('/')->withInput(Input::except('password'));
			}
		}
	}

	public function logout()
	{
		// Cierro la sesion del usuario
		Auth::logout();
		Session::flush();
		return Redirect::to('/');
	}	
}