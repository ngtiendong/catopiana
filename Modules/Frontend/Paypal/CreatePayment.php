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
    public function create($data, $value)
    {
        $itemList = $this->createItemList($data);

        $payment = $this->payment($itemList, $value);
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
            return redirect()->route($value['routeBackError'])->with('buy_package_error' ,'There was an error! Please try again later');
        } catch (\Exception $e) {
            // die($e);
            return redirect()->route($value['routeBackError'])->with('buy_package_error' ,'There was an error! Please try again later');
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
    protected function transaction( $itemList, $value): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->amount())
            ->setItemList($itemList)
            ->setDescription($value['description'])
            ->setInvoiceNumber(uniqid());
        return $transaction;
    }

    /**
     * @return RedirectUrls
     */
    protected function redirectUrls($value): RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($value['returnUrl'])
            ->setCancelUrl($value['cancelUrl']);
        return $redirectUrls;
    }

    /**
     * @param $itemList
     * @return Payment
     */
    protected function payment($itemList, $value): Payment
    {
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($this->payer())
            ->setRedirectUrls($this->redirectUrls($value))
            ->setTransactions([$this->transaction($itemList, $value)]);
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