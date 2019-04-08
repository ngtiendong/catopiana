<?php

namespace Modules\Frontend\Services;

use Modules\Frontend\Entities\Curriculum;
use Modules\Frontend\Entities\CustomerPayment;
use Modules\Frontend\Entities\CustomerCurriculum;
use PayPal\Api\Payment;

class PaymentService
{
    public function getCurriculumData($something = null)
    {   
        // can pass array of id curriculum to query
        $data = [];
        $curriculums = Curriculum::with('topic')->where('type',1)->get();
        foreach($curriculums as $key => $curriculum)
        {
            $data[] = [
                'name'     => 'Curriculum '. $curriculum->topic->name . ' level '. $curriculum->level,
                'sku'      =>  $key + 1 ,
                'price'    => '70'
            ];
        }
        return $data;
    }

    public function saveData($payment_result)
    {
        $customer_id = auth()->guard('customers')->user()->id;
        $transaction = $payment_result->transactions[0];
        $payment_amount = $transaction->amount->total;
        $curriculum_ids = [];
        // change it, get Data
        foreach(Curriculum::with('topic')->where('type',1)->get() as $curriculum){
            $curriculum_ids[] =  $curriculum['id'];
        }
        $customerPayment = CustomerPayment::create([
            'customer_id' => $customer_id,
            'payment_type' => 0, // paypal:0
            'payment_info' => 0, // changed it
            'payment_amount' => $payment_amount,
            'curriculum_ids' => json_encode($curriculum_ids)
        ]);
        foreach ($curriculum_ids as $curriculum_id) {
            $customerPayment->customer_curriculum()->create([
                'curriculum_id' => $curriculum_id,
                'customer_id' => $customerPayment->customer_id
            ]);
        }
        return ;
        
    }

}
