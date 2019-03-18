<?php

namespace Modules\Core\Lib;

use Illuminate\Support\Facades\Log;
use Nwidart\Modules\Facades\Module;

class PushNotification
{
    /**
     * @param $deviceToken
     * @param $deviceOs
     * @param $message
     * @param $customData
     * @param int $badgeNum
     */
    public static function sendNotification($deviceToken, $deviceOs, $message, $customData, $badgeNum = 0)
    {
        try {
            // Send notify by device os
            switch (strtolower($deviceOs))
            {
                case 'android':
                    self::androidSend($deviceToken, $message, $customData, $badgeNum);
                    break;
                case 'ios':
                    self::iosSend($deviceToken, $message, $customData, $badgeNum);
                    break;
            }
        } catch (\Exception $ex) {
            Log::error('Error send push:');
            Log::error($ex->getMessage());
        }
    }
    
    /**
     * @param $devicesTokens
     * @param $message
     * @param $customData
     * @param int $badgeNum
     */
    public static function sendMultiDevices($devicesTokens, $message, $customData, $badgeNum = 0)
    {
        Log::error('KKK: ' . \GuzzleHttp\json_encode($devicesTokens));
        // Send push
        if (!empty($devicesTokens['ios'])) {
            self::iosSendMulti($devicesTokens['ios'], $message, $customData, $badgeNum);
        }
        if (!empty($devicesTokens['android'])) {
            self::androidSend($devicesTokens['android'], $message, $customData, $badgeNum);
        }
    }

    /**
     * @param $deviceToken
     * @param $msgBody
     * @param array $customProperty
     * @param int $badgeNum
     * @return bool
     */
    private static function iosSend($deviceToken, $msgBody, $customProperty = array(), $badgeNum = 0)
    {
        // Sandbox or Production
        switch (config('notification.env_apns'))
        {
            // Sandbox
            case 'sandbox':
                $push = new \ApnsPHP_Push(
                    \ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
                    config_path() . '/notification/apns/' . config('pushnotification.apns_apple.sandbox')
                );
                break;
            // Production
            case 'production':
                $push = new \ApnsPHP_Push(
                    \ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
                    config_path() . '/notification/apns/' . config('pushnotification.apns_apple.production')
                );
                break;
        }
        if (isset($push)) {
            // Set certification authority
            $push->setRootCertificationAuthority(config_path() . '/notification/apns/entrust_root_certification_authority.pem');
            $push->setLogger(new CustomApnsLog());
            // Connect
            $push->connect();
            try {
                // Set device token
                $message = new \ApnsPHP_Message($deviceToken);
                foreach($customProperty as $key => $val){
                    $message->setCustomProperty($key, $val);
                }
                $message->setBadge(intval($badgeNum));
                $message->setSound();
                // Set text
                $message->setText($msgBody);
                // Add message
                $push->add($message);
                // Send push
                $push->send();
            } catch (\ApnsPHP_Message_Exception $e) {
                Log::error($e->getMessage());
            }
            // Disconnect
            $push->disconnect();
            // Get error
            $errorQueue = $push->getErrors();
            // Show error queue
            if (!empty($errorQueue)) {
                Log::error(json_encode($errorQueue));
                return false;
            }
        }
        return true;
    }
    /**
     * @param $devicesTokens
     * @param $msgBody
     * @param array $customProperty
     * @param int $badgeNum
     * @return bool
     */
    private static function iosSendMulti($devicesTokens, $msgBody, $customProperty = array(), $badgeNum = 0)
    {
        $module = Module::find('Core');
        // Sandbox or Production
        switch (config('notification.env_apns'))
        {
            // Sandbox
            case 'sandbox':
                $push = new \ApnsPHP_Push(
                    \ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
                    $module->getPath() . '/Config/notification/apns/' . config('notification.apns_apple.sandbox')
                );
                break;
            // Production
            case 'production':
                $push = new \ApnsPHP_Push(
                    \ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
                    $module->getPath() . '/Config/notification/apns/' . config('notification.apns_apple.production')
                );
                break;
        }

        if (isset($push)) {
            // Set certification authority
            $push->setRootCertificationAuthority($module->getPath() . '/Config/notification/apns/entrust_root_certification_authority.pem');
            $push->setLogger(new CustomApnsLog());
            // Connect
            $push->connect();
            // Send to all device
            foreach ($devicesTokens as $deviceToken) {
                if (!empty($devicesToken)) {
                    try {
                        // Set device token
                        $message = new \ApnsPHP_Message($deviceToken);
                        foreach($customProperty as $key => $val){
                            $message->setCustomProperty($key, $val);
                        }
                        $message->setBadge(intval($badgeNum));
                        $message->setSound();
                        // Set text
                        $message->setText($msgBody);
                        // Add message
                        $push->add($message);
                        // Send push
                        $push->send();
                        Log::error("1. {$deviceToken} {$msgBody}");
                    }
                    catch (\ApnsPHP_Message_Exception $e) {
                        Log::error("2. {$deviceToken} {$msgBody}");
                        Log::error($e->getMessage());
                    }
                }
            }
            // Disconnect
            $push->disconnect();
            // Get error
            $errorQueue = $push->getErrors();
            // Show error queue
            if (!empty($errorQueue)) {
                Log::error(json_encode($errorQueue));
                return false;
            }
        }
        return true;
    }
    private static function androidSend($deviceTokens, $msgBody, $customProperty = array(), $badgeNum = 0)
    {
        $result = false;
        // Check service
        switch (config('notification.google.service')) {
            case 'gcm':
                $result = self::gcmSend($deviceTokens, $msgBody, $customProperty, $badgeNum);
                break;
            case 'fcm':
                $result = self::fcmSend($deviceTokens, $msgBody, $customProperty, $badgeNum);
                break;
        }
        return $result;
    }
    private static function fcmSend($deviceTokens, $msgBody, $customProperty = array(), $badgeNum = 0)
    {
        // Build message
        $msgBody = array(
            'aps' => array(
                'badge' => 10,
                'alert' => $msgBody,
                'sound' => 'default.caf'
            )
        );
        if (is_array($customProperty) && !empty($customProperty)) {
            foreach ($customProperty as $key => $val) {
                $msgBody[$key] = $val;
            }
        }
        $message = array(
            'title' => '',
            'message' => json_encode($msgBody),
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1,
            'badge' => $badgeNum
        );
        $key = config('notification.google.fcm.api_key');
        $headers = array(
            'Authorization: key= ' . $key,
            'Content-Type: application/json'
        );
        $fields = array(
            'registration_ids' => is_array($deviceTokens) ? $deviceTokens : array($deviceTokens),
            'data' => $message,
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, config('notification.google.fcm.push_url'));
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        //curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        if ($result === FALSE) {
            Log::error('FCM error: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        return $result;
    }

    private static function gcmSend($deviceTokens, $msgBody, $customProperty = array(), $badgeNum = 0)
    {
        // Build message
        $msgBody = array(
            'aps' => array(
                'badge' => 10,
                'alert' => $msgBody,
                'sound' => 'default.caf'
            )
        );
        if (is_array($customProperty) && !empty($customProperty)) {
            foreach ($customProperty as $key => $val) {
                $msgBody[$key] = $val;
            }
        }
        $message = array(
            'title' => '',
            'message' => json_encode($msgBody),
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1,
            'badge' => $badgeNum
        );

        $key = config('pushnotification.google.gcm.api_key');

        $headers = array(
            'Authorization: key= ' . $key,
            'Content-Type: application/json'
        );
        $fields = array(
            'registration_ids' => is_array($deviceTokens) ? $deviceTokens : array($deviceTokens),
            'data' => $message,
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, config('pushnotification.google.gcm.push_url'));
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        return $result;
    }
}

class CustomApnsLog implements \ApnsPHP_Log_Interface
{
    function log($sMessage)
    {
        Log::error($sMessage);
    }
}