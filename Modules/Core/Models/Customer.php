<?php

namespace Modules\Core\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Modules\Frontend\Entities\CustomerTesting;
use Modules\Frontend\Entities\Package;

class Customer extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'customers';
    protected $fillable = ["username", "email", "password", "fullname", "phone",'provider_id','provider_name','test_status'];

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    public function getUsernameAttribute()
    {
        if(strlen($this->attributes['username']) < 9)
        {
            return $this->attributes['username'];
        }
        return mb_substr($this->attributes['username'],0,6)."...";
    }

    protected $hidden = [
            'password','remember_token'
        ];
    /**
     * Get customer avatar
     * @return string
     */
    public static function getUserAvatar(){
        $user = auth()->user();
        $avatar = $user->avatar;
        if ($user->sex == 0) {
            $customerAvatar = asset('/img/icon_female.png');
        } else {
            $customerAvatar = asset('/img/icon_male.png');
        }
        if (!empty($avatar)) {
            $avatarArray = json_decode($avatar, true);
            $customerAvatar = $avatarArray['medium_url'];
        }

        return $customerAvatar;
    }

    public function customer_testing()
    {
        return $this->hasMany(CustomerTesting::class,'customer_id');
    }

    public function customer_package()
    {
        return $this->hasMany(CustomerPackage::class,'customer_id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class,'customer_package');
    }
}
