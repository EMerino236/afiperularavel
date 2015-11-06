<?php namespace api\v1;

use \User;
use \Periodo;
use \UsersPeriodo;
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
                $can_reapply = 0;
                $period = null;
                foreach ($perfiles as $perfil)
                {
                    $perfiles_array[] = [
                        'id' => $perfil->idperfiles,
                        'name' => $perfil->nombre
                    ];
                    if ($perfil->idperfiles == 3)
                    {
                        $sgtePeriodo = Periodo::getFuturePeriodos()->first();
                        if ($sgtePeriodo)
                        {
                            $userPeriodo = UsersPeriodo::getUsersPeriodoByUserXPeriodo($sgtePeriodo->idperiodos, $user->id)->first();
                            if (!$userPeriodo)
                            {
                                $can_reapply = 1;
                                $period_element['id'] = $sgtePeriodo->idperiodos;
                                $period_element['name'] = $sgtePeriodo->nombre;
                                $period = $period_element;
                            }
                            else
                                $can_reapply = 0;
                        }
                    }
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
                        'email' => $user->email,
                        'profiles' => $perfiles_array,
            			'actions' => $permisos_array,
                        'can_reapply' => $can_reapply,
                        'period' => $period,
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
