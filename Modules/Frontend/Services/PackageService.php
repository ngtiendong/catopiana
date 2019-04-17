<?php

namespace Modules\Frontend\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Frontend\Entities\Curriculum;
use Modules\Frontend\Entities\CustomerTesting;
use Modules\Frontend\Entities\Topic;
use Modules\Core\Models\Customer;
use Modules\Frontend\Entities\Package;

class PackageService
{
    protected $customer;
    public function __construct()
    {
        $this->customer = auth()->guard('customers')->user();
    }


    public function checkDoneFreeQuestion()
    {
        $this->customer = auth()->guard('customers')->user();
        $topic_init_free_id = Topic::where('type',0)->pluck('id')->toArray();
        $testings = $this->customer->customer_testing->where('status', 1);
        $test_free_id_done = [];
        foreach ($testings as $testing) {
            $test_free_id_done[] = Curriculum::where('id',json_decode($testing->curriculum_id)[0])->first()->topic_id;
        }
        $diff = collect($topic_init_free_id)->diff($test_free_id_done);
        if($diff->count() == 0)
        {
            return $this->giveFreePackage();
        } else {
            return false;
        }
    }

    protected function giveFreePackage()
    {
        $package = Package::where('type', 0)->first(); // package 0 free - 1 paid
        $this->customer->update(['test_status' => 1]);
        $this->customer->packages()->attach($package->id,[
            'payment_amount' => 0,
            'payment_info' => 'free for customer',
            'payment_type' => null,
            'payment_status' => null
        ]);
        return true;
    }

    public function getFreePackage()
    {
        $this->customer = auth()->guard('customers')->user();
        $package = $this->customer->packages()->with('curriculums','curriculums.topic')->where('type',0)->first();
        if ($package == null){
            return null;
        }
        $curriculums = $package->curriculums;
        return $curriculums;
    }

    public function getPaidPackage()
    {
        $this->customer = auth()->guard('customers')->user();
        $package = $this->customer->packages()->with('curriculums','curriculums.topic')->where('type',1)->first();
        if ($package == null){
            return null;
        }
        $curriculums = $package->curriculums;
        return $curriculums;
    }

    // public function getTopicOfPackage($customer, $curriculum_id)
    // {
    //     $curriculum = Curriculum::find($curriculum_id);
    //     $package_have_curriculums = $curriculum->packages;
    // }
}
