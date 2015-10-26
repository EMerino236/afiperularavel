<?php namespace api\v1;

use \User;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class SessionController extends \BaseController {

	public function sign_in()
	{
		$num_documento = Input::get('username');
		$password = Input::get('password');
		$user = User::searchUserByDocumentNumber($num_documento)->first();
    	if ($user)
    	{
    		if (\Hash::check($password, $user->password))
    		{
                $perfiles = User::getPerfilesPorUsuario2($user->id)->get();
                $perfiles_array = array();
                foreach ($perfiles as $perfil)
                {
                    $perfiles_array[] = [
                        'id' => $perfil->idperfiles,
                        'name' => $perfil->nombre
                    ];
                }
    			$permisos = User::getPermisosPorUsuarioId($user->id)->get();
				$permisos_array = array();
				foreach ($permisos as $p)
				{
					$permisos_array[] = ['id' => $p->idpermisos];
				}
        		$response = [
            			'id' => $user->id,
            			'names' => $user->nombres,
            			'last_name' => $user->apellido_pat,
            			'username' => $user->num_documento,
                        'profiles' => $perfiles_array,
            			'actions' => $permisos_array,
            			'auth_token' => $user->auth_token
        		];

        		return Response::json($response, 200);
    		}
            else
            {
                $response = array('error' => 'El usuario y la contraseña no coinciden.');
                return Response::json($response, 200);
            }
    	}
        
    	$response = array('error' => 'El nombre de usuario no existe.');
    	return Response::json($response, 200);
	}
}
