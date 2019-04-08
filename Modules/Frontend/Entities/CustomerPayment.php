<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    protected $guarded = [];
    protected $table = 'customer_payment';

    public function customer()
    {
    	return $this->belongsTo(Customer::class,'customer_id');
    }

    public function customer_curriculum()
    {
    	return $this->hasMany(CustomerCurriculum::class,'payment_id');
    } 
}
