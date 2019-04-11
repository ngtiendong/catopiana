<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Frontend\Paypal\CreatePayment;
use Modules\Frontend\Paypal\ExecutePayment;
use Illuminate\Routing\Controller;
use Modules\Frontend\Services\PaymentService;

class PaypalController extends Controller
{
   //This will hold the OAUTH 2.0 Credentials
    private $_apiContext;
    //We will authorize ourselves with PayPal everytime before we do anything
        public function __construct()
        {
            $this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));

            $this->_apiContext->setConfig(array(
                'mode' => 'sandbox',
                'service.EndPoint' => 'https://api.sandbox.paypal.com',
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => 'FINE'
    ));
        }
    //The user clicked the buy button, get the neccessary info to fill out the paypal express checkout
        public function getCheckout(){}
    // The user said yes, you made a sale! Here you want to get money from them and do other related actions (maybe even say thanks to the customer).
        public function getDone(Request $request){}
    // The user got scared and bailed, this is where Keyboard throwing is allowed
        public function getCancel(){}
    }

}
