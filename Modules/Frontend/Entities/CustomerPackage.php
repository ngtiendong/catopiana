<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;

class CustomerPackage extends Model
{
    protected $guarded = [];
    protected $table = 'customer_package';

    public function customer()
    {
    	return $this->belongsTo(Customer::class,'customer_id');
    }

    public function package()
    {
    	return $this->belongsTo(Package::class,'package_id');
    } 
}
