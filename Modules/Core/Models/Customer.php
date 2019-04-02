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

    public function getUsernameAttribute()
    {
        if(strlen($this->attributes['username']) < 9)
        {
            return $this->attributes['username'];
        }
        return substr($this->attributes['username'],0,8).'...';
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

    public function customer_question()
    {
        return $this->hasMany(CustomerQuestion::class,'customer_id');
    }


    public function saveDataLocalStorage($data)
    {
        // luuw chuaw check
        foreach($data['question'] as $question){
            // for with type
            if($question['type'] != 8 || $question['type'] != 1){
                $question_data = $question['question_data'];
                foreach($question['answers'] as $key => $answer){
                    // question_data has type, question_data, question_index, question_id, question_curriculum
                    $this->customer_question()->create([
                        'question_id' => $question_data[$key]['question_id'],
                        'answer' =>  $answer
                    ]);
                }
            }
        }

    }

}
