<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Core\Models\User;

class SocialAccount extends Model
{
    protected $fillable = ['provider_name','provider_id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }


}
