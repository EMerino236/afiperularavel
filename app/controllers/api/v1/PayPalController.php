<?php namespace api\v1;

class PayPalController extends \BaseController {

	public function verify()
	{
        $rules = array('payment_id' => 'required',
                       'payment_client' => 'required',
                       'fee_id' => 'required'
        );
        $validator = \Validator::make(\Input::all(), $rules);
        if($validator->fails())
            return \Response::json(['error' => 'Los parámetros payment_id, payment_client y fee_id son obligatorios.'], 200);
        
		$payment_id = \Input::get('payment_id');
        $payment_client = json_decode(\Input::get('payment_client'));
        $fee_id = \Input::get('fee_id');
        
        // get access token
        $credentials = 'AaojGtvv8YNz-PGOlN3B9qeKdu8UaWRDgGg5RBQgByyAaru1-kVTY4B5zQB1ZnSFqcKMBmuXsSdaHmow'. ':' . 'EOutb3ahbyP4iJsRL2NAGTfaJJZaoxqNW3Rqp-olcludUMKs0l2VB4Izo_WTt6hsTOvF0j7cjl-ABqJ6';
        $process = curl_init('https://api.sandbox.paypal.com/v1/oauth2/token?grant_type=client_credentials');
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($process, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Accept-Language: en_US', 'Authorization: Basic ' . base64_encode($credentials)));
        curl_setopt($process, CURLOPT_HEADER, FALSE);
        //curl_setopt($process, CURLOPT_USERPWD, 'EOJ2S-Z6OoN_le_KS1d75wsZ6y0SFdVsY9183IvxFyZp' . ':' . 'EClusMEUk8e9ihI7ZdVLF5cZ6y0SFdVsY9183IvxFyZp');
        //curl_setopt($process, CURLOPT_TIMEOUT, 30);
        //curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($process);
        curl_close($process);
        
        $response_json = json_decode($response);
        $token = $response_json->access_token;

        // get payment details
        $process = curl_init('https://api.sandbox.paypal.com/v1/payments/payment/' . $payment_id);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer ' . $token));
        curl_setopt($process, CURLOPT_HEADER, FALSE);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($process);
        curl_close($process);
        
        $payment = json_decode($response);
        //$payment = json_decode(\Input::get('payment_test'));
        //return \Response::json($payment, 200);
        
        if(!array_key_exists('state', $payment)) 
            return \Response::json(['error' => 'No se encontró el pago con id = ' . $payment_id], 200);
        
        // verify the state approved
        if($payment->state != 'approved')
            return \Response::json(['error' => 'El pago no ha sido aprobado. Su estado es ' . $payment->state], 200);
        
        // amount on client side
        $amount_client = $payment_client->amount;
        
        // currency on client side
        $currency_client = $payment_client->currency_code;
        
        // PayPal transactions
        $transactions = $payment->transactions;
        $transaction = $transactions[0];
        
        // amount on server side
        $amount_server = $transaction->amount->total;
        
        // currency on server side
        $currency_server = $transaction->amount->currency;
        $related_resources = $transaction->related_resources;
        $sale_state = $related_resources[0]->sale->state;
        
        // verify the amount
        if ($amount_server != $amount_client)
            return \Response::json(['error' => 'Los montos del pago no coinciden.'], 200);
        
        // verify the currency
        if ($currency_server != $currency_client) 
            return \Response::json(['error' => 'El tipo de moneda no coincide.'], 200);
        
        // verify the sale state
        if ($sale_state != 'completed')
            return \Response::json(['error' => 'Venta no completada.'], 200);
        
        // update payment in the db
        $fee = \CalendarioPago::find($fee_id);
        //return $fee;
        $fecha_pago = \DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $payment->create_time);
        $fee->fecha_pago = $fecha_pago->format('Y-m-d H:i:s');
        $fee->aprobacion = 2;
        $fee->save();
        
        return \Response::json(['success' => 1], 200);
        
    }

}
