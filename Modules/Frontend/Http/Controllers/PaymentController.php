<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Frontend\Paypal\CreatePayment;
use Modules\Frontend\Entities\CustomerPackage;
use Modules\Frontend\Paypal\ExecutePayment;
use Illuminate\Routing\Controller;
use Modules\Frontend\Services\PaymentService;

class PaymentController extends Controller
{
    protected $payment_service;

    public function __construct(PaymentService $service)
    {
        $this->middleware('auth:customers');
        $this->payment_service = $service;
    }

    public function buyPackage()
    {
        return view('frontend::paypals.test');
    }

    public function create(Request $request)
    {   
        $data = $this->payment_service->getCurriculumData($request->price);
        // fix cung du lieu nen check custome đã mua package này chưa! hiện tại fix cứng package id 2
        $customer_package = CustomerPackage::where('customer_id', auth()->guard('customers')->user()->id)->where('package_id',2)->first();
        if($customer_package){
            return redirect('packages')->with('buy_package_error' ,'You already have this package before!');
        }
        $payment = new CreatePayment;
        return $payment->create($data);
    }

    public function execute()
    {
        $payment = new ExecutePayment;
        $execute = $this->payment_service->saveData($payment->execute());
        // dd($execute);
        return redirect('packages')->with('buy_package_success' ,'You have bought the question package successfully!');
    }
}
