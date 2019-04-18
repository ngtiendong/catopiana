<?php

namespace Modules\Frontend\Services;

use Modules\Frontend\Entities\Curriculum;
use Modules\Frontend\Entities\CustomerPackage;
use Modules\Frontend\Entities\CustomerCurriculum;
use PayPal\Api\Payment;

class PaymentService
{
    public function getCurriculumData($something = null)
    {   
        // can pass array of id curriculum to query
        $data = [];
        // $curriculums = Curriculum::with('topic')->where('type',0)->take(2)->get();
        // foreach($curriculums as $key => $curriculum)
        // {
            $data[] = [
                'name'     => 'Question Package ++',
                'sku'      =>   1,
                'price'    => $something
            ];
        // }
        return $data;
    }

    public function saveData($payment_result)
    {
        $customer_id = auth()->guard('customers')->user()->id;
        $transaction = $payment_result->transactions[0];
        $payment_amount = $transaction->amount->total;
        // $curriculum_ids = [];
        // change it, get Data
        // foreach(Curriculum::with('topic')->where('type',1)->get() as $curriculum){
        //     $curriculum_ids[] =  $curriculum['id'];
        // }
        $customerPayment = CustomerPackage::create([
            'customer_id' => $customer_id,
            'package_id' => 2,
            'payment_type' => 0, // paypal:0
            'payment_info' => 0, // changed it
            'payment_status' => 0, // changed it
            'payment_amount' => $payment_amount
        ]);
        return ;
        
    }

}
