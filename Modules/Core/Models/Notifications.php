<?php

namespace Modules\Core\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Jobs\SendPushMulti;

class Notifications extends Model
{
    protected $table = 'notifications';

    protected $guarded = [];


    public static function getBaseList($params)
    {
        $query = self::whereNull('deleted_at')->select('*');

        if (!empty($params["title"])) {
            $query->where('title','LIKE', '%'.$params['title'].'%');
        }
        if (!empty($params["member_type"])) {
            $query->where('member_type','=',$params["member_type"]);
        }
        if (!empty($params["schedule"])) {
            $query->whereDate('schedule',$params["schedule"]);
        }

        return $query;
    }
    public static function createNotification($params)
    {
        if (!empty($params)) {
            $now = Carbon::now();
            $delay = $now->diffInMinutes($params["schedule"]);

            $is_success = self::create([
                'title' => $params["title"],
                'member_type' => $params["member_type"],
                'message' => $params["message"],
                'schedule' => $params["schedule"]
            ]);

            if (!empty($is_success)) {
                //Push job
//                SendPushMulti::dispatch([],$params["message"])->delay(now()->addMinutes($delay));

            }

            return $is_success;
        } return null;
    }

}
