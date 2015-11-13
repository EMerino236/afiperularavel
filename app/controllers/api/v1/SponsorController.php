<?php namespace api\v1;

use \User;
use \Padrino;
use \CalendarioPago;
use \Documento;
use \DocumentosPadrino;
use \DateTime;
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
    		$date = Input::get('date');

    		if ($idcalendario_pagos && $opcode && $date)
    		{
    			$cuota = CalendarioPago::find($idcalendario_pagos);
    			$cuota->num_comprobante = $opcode;
    			$cuota->fecha_pago = date('Y-m-d H:i:s', $date);

    			$cuota->save();

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
                    $responseCalendar_element["fee_number"] = $fee->num_cuota;
                    $status = -1;
                    if ($fee->aprobacion)
                    {
                        $status = 2;
                    }
                    else
                    {
                        $today = date("Y-m-d");
                        $expire = $fee->vencimiento;
                        $payment_date = $fee->fecha_pago;

                        $today_time = strtotime($today);
                        $expire_time = strtotime($expire);
                        $payment_time = null;
                        if ($payment_date) 
                        {
                            $payment_time = strtotime($payment_date);
                            $status = 3;
                        }
                        else
                        {
                            if ($today_time >= $expire_time)
                                $status = 0;
                            else if ($today_time < $expire_time)
                                $status = 1;
                        }
                    }
                    $responseCalendar_element["status"] = $status;

                    $responseCalendar[] = $responseCalendar_element;
                }

                $response = $responseCalendar;
                $status_code = 200;
                return Response::json($response, $status_code);
            }
            else
            {
                $response = [ 'error' => 'El usuario no es un padrino.'];
                $status_code = 200;
                return Response::json($response, $status_code);
            }
        }

        $response = [ 'error' => 'Error en la autenticación.'];
        $status_code = 401;
        return Response::json($response, $status_code);
    }

    public function activity_reports()
    {
        $auth_token = Request::header('Authorization');
        $user = User::where('auth_token', '=', $auth_token)->first();

        if ($user)
        {
            $responseReports = []; $reports = [];
            $allReports = false; $myReports = false;
            $actions = User::getPermisosPorUsuarioId($user->id)->get();
            foreach ($actions as $a)
            {
                if ($a->idpermisos == 21)
                {
                    $allReports = true;
                    break;
                }
            }
            if ($allReports)
            {
                $reports = Documento::getDocumentosPorTipo(2)->get();
            }
            else
            {
                foreach ($actions as $a)
                {
                    if ($a->idpermisos == 39)
                    {
                        $myReports = true;
                        break;
                    }
                }
                if ($myReports)
                {
                    $sponsor = Padrino::getPadrinoByUserId($user->id)->first();
                    if ($sponsor)
                    {
                        $reports = DocumentosPadrino::getDocumentoIdsByPadrino($sponsor->idpadrinos)->get();
                    }
                    else
                    {
                        $response = [ 'error' => 'El usuario no tiene información de padrino registrada.'];
                        $status_code = 200;
                        return Response::json($response, $status_code);
                    }
                }
                else
                {
                    $response = [ 'error' => 'El usuario no tiene permiso para ver reportes.'];
                    $status_code = 200;
                    return Response::json($response, $status_code);
                }
            }

            foreach ($reports as $r)
            {
                $responseReports_element['id'] = $r->iddocumentos;
                $responseReports_element['name'] = $r->titulo;
                $responseReports_element['url'] = $r->ruta . $r->titulo;
                $responseReports_element['size'] = $r->peso . ' KB';

                $from = new DateTime();
                $from->setTimestamp(strtotime($r->created_at));
                $to = new DateTime('today');
                $dias = $from->diff($to)->d;
                $responseReports_element['upload_date'] = 'Hace ' . $dias . ' día' . (($dias != 1) ? 's' : '') . ', ' . date('h:i A', $from->getTimestamp());

                $responseReports[] = $responseReports_element;
            }

            $response = $responseReports;
            $status_code = 200;
            return Response::json($response, $status_code);
        }

        $response = [ 'error' => 'Error en la autenticación.'];
        $status_code = 401;
        return Response::json($response, $status_code);
    }

}
