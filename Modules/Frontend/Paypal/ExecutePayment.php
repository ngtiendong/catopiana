<?php
namespace Modules\Frontend\Paypal;


use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class ExecutePayment extends Paypal
{
    protected $amount;
    public function execute()
    {
        $payment = $this->getThePayment();
        // get total price from url create Payment
        $this->amount = (float)($payment->getTransactions()[0]->amount->total);
        $execution = $this->createExecution();
        $execution->addTransaction($this->transaction());
        try {
            // Execute payment
            $result = $payment->execute($execution, $this->apiContext);
        } catch (PayPal\Exception\PayPalConnectionException $e) {
            echo $e->getCode();
            echo $e->getData();
            die($e);
        } catch (\Exception $e) {
            die($e);
        }
        return $result;
    }

    /**
     * Get payment object by passing 'paymentId'
     * @return Payment
     */
    protected function getThePayment(): Payment
    {
        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);
        return $payment;
    }

    /**
     * create execution payment with 'PayerID'
     * @return PaymentExecution
     */
    protected function createExecution(): PaymentExecution
    {
        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));
        return $execution;
    }

    /**
     * @return Transaction
     */
    protected function transaction(): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->amount()); // check amount
        return $transaction;
    }
}