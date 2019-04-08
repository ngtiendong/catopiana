<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;

class CustomerCurriculum extends Model
{
    protected $guarded = [];
    protected $table = 'customer_curriculum';

    public function customer_payment()
    {
    	return $this->belongsTo(CustomerPayment::class,'payment_id');
    }
}
