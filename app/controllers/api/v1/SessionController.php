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
            			'actions' => $permisos_array,
            			'auth_token' => $user->auth_token
        		];
        
        		$status_code = 200;
        		return Response::json($response, $status_code);
    		}
    	}
    
    	$status_code = 401;
    	$response = array('error' => 1);
    	return Response::json($response, $status_code);
	}
}
