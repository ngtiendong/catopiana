<?php

namespace Modules\Core\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Customer extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'customers';
    protected $fillable = ["username", "email", "password", "fullname", "phone",'provider_id','provider_name'];

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
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
}
