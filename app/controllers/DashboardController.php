<?php

class DashboardController extends BaseController
{
	public function home()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$data["permisos"] = Session::get('permisos');
			return View::make('dashboard/dashboard',$data);
		}else{
			return View::make('error/error');
		}
	}
}