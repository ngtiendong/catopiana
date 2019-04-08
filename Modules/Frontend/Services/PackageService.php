<?php

namespace Modules\Frontend\Services;

use Modules\Frontend\Entities\Curriculum;
use Modules\Frontend\Entities\CustomerTesting;
use Modules\Frontend\Entities\Topic;
use Modules\Core\Models\Customer;
use Modules\Frontend\Entities\Package;

class PackageService
{
    protected $customer;
    public function checkDoneFreeQuestion()
    {
        $this->customer = auth()->guard('customers')->user();
        $topic_init_free_id = Topic::where('type',0)->pluck('id')->toArray();
        $testings = $this->customer->customer_testing->where('status',1);
        $test_free_id_done = [];
        foreach ($testings as $testing) {
            $test_free_id_done[] = Curriculum::where('id',json_decode($testing->curriculum_id)[0])->first()->topic_id;
        }
        $diff = collect($topic_init_free_id)->diff($test_free_id_done);
        if($diff->count() == 0)
        { 
            $this->giveFreePackage();
        } else {
            return ;
        }
    }

    protected function giveFreePackage()
    {
        $package = Package::where('type', 0)->first(); 
        $this->customer->update(['test_status' => 1]);
        $this->customer->packages()->attach($package->id,[
            'payment_amount' => 0,
            'payment_info' => 'free for customer',
            'payment_type' => null,
            'payment_status' => null
        ]);
        return;
    }
}
