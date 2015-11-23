<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class IndexController extends BaseController
{
    
    private $_api_context;

    public function __construct()
    {
        
        // setup PayPal api context
        $paypal_conf = Config::get('paypal');        
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
   

    public function postPayment()
    {
        

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $monto = Input::get('monto');
        //echo '<pre>';print_r($monto);echo '</pre>';exit;
        $item_1 = new Item();        
        $item_1->setName('Monto Pago Cuota AFI Perú') // item name
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($monto); // unit price

        $item_2 = new Item();
        $item_2->setName('Item 2')
            ->setCurrency('PEN')
            ->setQuantity(4)
            ->setPrice('7');

        $item_3 = new Item();
        $item_3->setName('Item 3')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice('20');

        // add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($monto);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status'))
            ->setCancelUrl(URL::route('payment.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die('Some error occur, sorry for inconvenient');
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());
        Session::put('idcalendario_pago', Input::get('idcalendario_pagos'));

        if(isset($redirect_url)) {
            // redirect to paypal
            return Redirect::away($redirect_url);
        }

        return Redirect::route('original.route')
            ->with('error', 'Unknown error occurred');
    }

    public function getPaymentStatus()
    {
        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');
        //echo '<pre>';print_r($payment_id);echo '</pre>';exit;
        // clear the session payment ID
        Session::forget('paypal_payment_id');
        //echo '<pre>';print_r(1);echo '</pre>';exit;
        if (!Input::get('PayerID') || !Input::get('token')) {
            return Redirect::to('padrinos/list_registrar_pagos')
                ->with('error', 'El pago no se realizó correctamente');
        }
        //echo '<pre>';print_r($this->_api_context);echo '</pre>';exit; 

        $payment = Payment::get($payment_id, $this->_api_context);

        
        // PaymentExecution object includes information necessary 
        // to execute a PayPal account payment. 
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        //echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later

        if ($result->getState() == 'approved') { // payment made
            $idpago = Session::get('idcalendario_pago');
            //echo '<pre>';print_r($idpago);echo '</pre>';exit;
            $pago = CalendarioPago::find($idpago);
            $pago->fecha_pago = date("Y-m-d");
            $pago->banco = "PayPal";
            $pago->aprobacion = 1;
            $pago->save();

            return Redirect::to('padrinos/list_registrar_pagos')
                ->with('message', 'El pago se realizó correctamente');
        }
        return Redirect::to('padrinos/list_registrar_pagos')
            ->with('error', 'El pago no se realizó correctamente');
    }
}