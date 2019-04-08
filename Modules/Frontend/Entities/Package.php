<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Customer;

class Package extends Model
{
    protected $guarded = [];
    protected $table = 'packages';

    public function customers()
    {
        return $this->belongsToMany(Customer::class,'customer_package');
    }
}
