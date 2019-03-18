<?php
/**
 * Created by PhpStorm.
 * User: PhongBui
 * Date: 10/12/2017
 * Time: 10:43 PM
 */

namespace Modules\Core\Lib;


use Modules\Core\Models\OauthAccessToken;

class PushNotificationHelper
{
    /**
     * Send notification for multi device
     *
     * @param $userIds
     * @param $message
     * @param $customData
     * @param int $badgeNum
     * @param int $projectId
     */
    public static function sendNotificationMulti($userIds, $message, $customData, $badgeNum = 0, $projectId = 0)
    {
        $users = User::whereIn('id', $userIds)->get();
        if ($users) {
            // Group by os
            $devicesTokens = [
                'ios' => [],
                'android' => []
            ];
            /* @var $device UserDevice */
            foreach ($users as $user) {
                if (!empty($user->device_token)) {
                    switch (strtolower($user->mobile_type)) {
                        case 'android':
                            if (!in_array($user->device_token, $devicesTokens['android'])) {
                                $devicesTokens['android'][] = $user->device_token;
                            }
                            break;
                        case 'ios':
                            if (!in_array($user->push_notification_id, $devicesTokens['ios'])) {
                                $devicesTokens['ios'][] = $user->device_token;
                            }
                            break;
                    }
                }
            }
            // Send push
            PushNotification::sendMultiDevices($devicesTokens, $message, $customData, $badgeNum, $projectId);
        }
    }

    /**
     * Send notification to customer
     *
     * @param $customerId
     * @param $message
     * @param $customData
     * @param int $badgeNum
     */
    public static function sendNotificationCustomer($customerId, $message, $customData, $badgeNum = 0)
    {
        // Get customer tokens
        $tokens = OauthAccessToken::getByCustomer($customerId);
        if ($tokens) {
            // Send push
            PushNotification::sendMultiDevices($tokens, $message, $customData, $badgeNum);
        }
    }
}