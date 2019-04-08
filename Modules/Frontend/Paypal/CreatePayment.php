<?php
namespace Modules\Frontend\Paypal;


use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class CreatePayment extends Paypal
{
    public function create($data)
    {
        $itemList = $this->createItemList($data);

        $payment = $this->payment($itemList);
        // Create payment with valid API context
        try {
            $payment->create($this->apiContext);
            // Get PayPal redirect URL and redirect the customer
            $approvalUrl = $payment->getApprovalLink();
        // Redirect the customer to $approvalUrl
        } catch (PayPal\Exception\PayPalConnectionException $e) {
            // echo $e->getCode();
            // echo $e->getData();
            // die($e);
            return redirect('/paypal-test');
        } catch (\Exception $e) {
            // die($e);
            return redirect('/paypal-test');
        }
        return redirect($approvalUrl);
    }

    /**
     * @return Payer
     */
    protected function payer(): Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        return $payer;
    }

    /**
     * @param $itemList
     * @return Transaction
     */
    protected function transaction( $itemList): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->amount())
            ->setItemList($itemList)
            ->setDescription('Payment description: "Buy Curriculum at Catopiana"')
            ->setInvoiceNumber(uniqid());
        return $transaction;
    }

    /**
     * @return RedirectUrls
     */
    protected function redirectUrls(): RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(config('services.paypal.url.redirect'))
            ->setCancelUrl(config('services.paypal.url.cancel'));
        return $redirectUrls;
    }

    /**
     * @param $itemList
     * @return Payment
     */
    protected function payment($itemList): Payment
    {
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($this->payer())
            ->setRedirectUrls($this->redirectUrls())
            ->setTransactions([$this->transaction($itemList)]);
        return $payment;
    }

    protected function createItemList($data)
    {
        $list = [];
        $totalPrice = 0;
        foreach ($data as $key => $value) {
            $item = new Item();
            $item->setName($value['name'])
                ->setCurrency(config('services.paypal.currency'))
                ->setQuantity(1) 
                ->setSku($value['sku']) // Similar to `item_number` in Classic API
                ->setPrice($value['price']);
            $list[] = $item;
            $totalPrice += $value['price'];
        }
        $this->setAmount($totalPrice);
        $itemList = new ItemList();
        $itemList->setItems($list);
        return $itemList;
    }
}