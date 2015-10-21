<?php namespace api\v1;

use \User;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Request;

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
	    		$response = [ 'error' => 'Password actual incorrecto.'];
	    		$status_code = 401;
	    		return Response::json($response, $status_code);
	    	}
    	}

    	$response = [ 'error' => 1];
		$status_code = 401;
		return Response::json($response, $status_code);
	}

}
