<?php

namespace Modules\Core\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Carbon\Carbon;

class OauthAccessToken extends Model
{
    protected $guarded = [];

    const TYPE_CUSTOMER = 0;
    const TYPE_AGENCY = 1;

    /**
     * @param $customerId
     * @return array
     */
    public static function getByCustomer($customerId)
    {
        $tokens = self::where('user_type', self::TYPE_CUSTOMER)->where('user_id', $customerId)->get()->toArray();

        if ($tokens) {
            // Group by os
            $tmpData = [];
            foreach ($tokens as $token) {
                if (!empty($token['device_os'])) {
                    if (!isset($tmpData[$token['device_os']])) {
                        $tmpData[$token['device_os']] = [];
                    }

                    $tmpData[$token['device_os']][] = $token['device_token'];
                } else {
                    if (!isset($tmpData['other'])) {
                        $tmpData['other'] = [];
                    }

                    $tmpData['other'][] = $token['device_token'];
                }
            }

            $tokens = $tmpData;
        }

        return $tokens;
    }

    /**
     * @param $customerId
     * @return array
     */
    public static function getByAgency($agencyId)
    {
        $tokens = self::where('user_type', self::TYPE_AGENCY)->where('user_id', $agencyId)->get()->toArray();

        if ($tokens) {
            // Group by os
            $tmpData = [];
            foreach ($tokens as $token) {
                if (!empty($token['device_os'])) {
                    if (!isset($tmpData[$token['device_os']])) {
                        $tmpData[$token['device_os']] = [];
                    }

                    $tmpData[$token['device_os']][] = $token['device_token'];
                } else {
                    if (!isset($tmpData['other'])) {
                        $tmpData['other'] = [];
                    }

                    $tmpData['other'][] = $token['device_token'];
                }
            }

            $tokens = $tmpData;
        }

        return $tokens;
    }
}
