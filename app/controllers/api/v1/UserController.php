<?php namespace api\v1;

use \User;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Request;
use \Password;

class UserController extends \BaseController {

	public function change_password()
	{
		$auth_token = Request::header('Authorization');
    	$user = User::where('auth_token', '=', $auth_token)->first();

    	if ($user)
    	{
    		$current_password = Input::get('current_password');
	    	$new_password = Input::get('new_password');

	    	if (\Hash::check($current_password, $user->password))
	    	{
                $user->password = \Hash::make($new_password);
	    		$user->save();

	    		$response = [ 'success' => 1];
	    		$status_code = 200;
	    		return Response::json($response, $status_code);
	    	}
	    	else
	    	{
	    		$response = [ 'error' => 'La contraseña actual es incorrecta.'];
	    		$status_code = 200;
	    		return Response::json($response, $status_code);
	    	}
    	}

    	$response = [ 'error' => 'Error en la autenticación.'];
		$status_code = 401;
		return Response::json($response, $status_code);
	}

	public function recover_password()
	{
		switch ($response = Password::remind(Input::only('email')))
		{
			case Password::INVALID_USER:
				return Response::json(['error' => 'E-mail no registrado.'], 200);

			case Password::REMINDER_SENT:
				return Response::json(['success' => 1], 200);
		}
	}

	public function users()
	{
		$auth_token = Request::header('Authorization');
    	$user = User::where('auth_token', '=', $auth_token)->first();

    	if ($user)
    	{
    		$users = User::getActiveUsersInfo()->get();

			foreach ($users as $u)
			{
				$user_element["id"] = $u->id;
				$user_element["names"] = $u->nombres;
				$user_element["last_name"] = $u->apellido_pat;
				$user_element["username"] = $u->num_documento;

				$perfiles = User::getPerfilesPorUsuario2($u->id)->get();
                $perfiles_array = array();
                foreach ($perfiles as $perfil)
                {
                    $perfiles_array[] = [
                        'id' => $perfil->idperfiles,
                        'name' => $perfil->nombre
                    ];
                }
                $user_element["profiles"] = $perfiles_array;

				$permisos = User::getPermisosPorUsuarioId($u->id)->get();
				$permisos_array = array();
				foreach ($permisos as $p)
				{
					$permisos_array[] = ['id' => $p->idpermisos];
				}
				$user_element["actions"] = $permisos_array;

				$user_element["auth_token"] = $u->auth_token;
				$user_array[] = $user_element;
			}

			return Response::json($user_array, 200);
    	}

    	$response = [ 'error' => 'Error en la autenticación.'];
		$status_code = 401;
		return Response::json($response, $status_code);
	}

}
