<?php namespace api\v1;

use \User;
use \Padrino;
use \CalendarioPago;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;
use \Illuminate\Support\Facades\Request;

class SponsorController extends \BaseController {

	public function payment()
	{
		$auth_token = Request::header('Authorization');
    	$user = User::where('auth_token', '=', $auth_token)->first();

    	if ($user)
    	{
    		$idcalendario_pagos = Input::get('fee_id');
    		$opcode = (int)Input::get('voucher_code');
    		$amount = (double)Input::get('amount');
    		$date = Input::get('date');

    		if ($idcalendario_pagos && $opcode && $amount && $date)
    		{
    			$cuota = CalendarioPago::find($idcalendario_pagos);
    			$cuota->num_comprobante = $opcode;
    			$cuota->monto = $amount;
    			$cuota->fecha_pago = date('Y-m-d H:i:s', $date);

    			//$cuota->save();

    			$response = [ 'success' => 1, 'fee' => $cuota ];
    			$status_code = 200;
    			return Response::json($response, $status_code);
    		}
    		else
    		{
    			$response = [ 'error' => 'Error en parámetros.'];
    			$status_code = 404;
				return Response::json($response, $status_code);
    		}
    	}

    	$response = [ 'error' => 'Error en la autenticación.'];
		$status_code = 401;
		return Response::json($response, $status_code);
	}

    public function payment_calendar()
    {
        $auth_token = Request::header('Authorization');
        $user = User::where('auth_token', '=', $auth_token)->first();

        if ($user)
        {
            $sponsor = Padrino::getPadrinoByUserId($user->id)->first();
            if ($sponsor)
            {
                $calendar = CalendarioPago::getCalendarioByPadrino($sponsor->idpadrinos)->get();
                $responseCalendar = [];
                foreach ($calendar as $fee)
                {
                    $responseCalendar_element["fee_id"] = $fee->idcalendario_pagos;
                    $responseCalendar_element["amount"] = $fee->monto;
                    $responseCalendar_element["due_date"] = strtotime($fee->vencimiento);
                    $responseCalendar_element["fee_number"] = $fee->idcalendario_pagos;

                    $responseCalendar[] = $responseCalendar_element;
                }

                $response = $responseCalendar;
                $status_code = 200;
                return Response::json($response, $status_code);
            }
            else
            {
                $response = [ 'error' => 'El usuario no es un padrino.'];
                $status_code = 404;
                return Response::json($response, $status_code);
            }
        }

        $response = [ 'error' => 'Error en la autenticación.'];
        $status_code = 401;
        return Response::json($response, $status_code);
    }

}
