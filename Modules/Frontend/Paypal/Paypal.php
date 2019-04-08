<?php
namespace Modules\Frontend\Paypal;


use PayPal\Api\Amount;
use PayPal\Api\Details;

class Paypal
{
    protected $apiContext;
    protected $amount;
    public function __construct()
    {
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.id'), // client id
                config('services.paypal.secret')
            )
        );
        $this->apiContext->setConfig(config('services.paypal.settings'));
    }

    /**
     * @return Details
     */
    // protected function details(): Details
    // {
        // $details = new Details();
        // $details->setShipping(1.2)
        //     ->setTax(1.3)
        //     ->setSubtotal(17.50);
        // return $details;
    // }

    /**
     * @return Amount
     */
    protected function amount(): Amount
    {
        $amount = new Amount();
        $amount->setCurrency(config('services.paypal.currency'));
        $amount->setTotal($this->amount);
        // $amount->setDetails($this->details());
        return $amount;
    }

    protected function setAmount($totalPrice)
    {
        $this->amount = $totalPrice;
    }

}