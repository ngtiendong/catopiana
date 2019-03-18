<?php
/**
 * Created by PhpStorm.
 * User: PhongBui
 * Date: 10/12/2017
 * Time: 10:52 PM
 */

namespace Modules\Core\Lib;


use Modules\Core\Lib\SmsService\ESms;
use Modules\Core\Lib\SmsService\Nexmo;
use Modules\Core\Lib\SmsService\SmsServiceInterface;

class SendSMS
{
    /**
     * @var SmsServiceInterface
     */
    protected $sendSmsService;

    public function __construct($service = '')
    {
        if (empty($service)) {
            $service = config('notification.sms_service');
        }

        // Create service
        switch ($service) {
            case 'nexmo':
                $this->sendSmsService = new Nexmo(config('notification.nexmo.api_key'), config('notification.nexmo.api_secret'));
                break;
            case 'esms':
                $this->sendSmsService = new ESms(config('notification.esms.api_key'), config('notification.esms.api_secret'));
                break;
        }
    }

    /**
     * @param $phoneNumber
     * @param $content
     * @return array
     */
    public function sendSms($phoneNumber, $content)
    {
        // Check sandbox env
        $isSandbox = false;
        if (config('notification.sms_sandbox') == 1) {
            $isSandbox = true;
        }

        return $this->sendSmsService->sendSms($phoneNumber, $content, $isSandbox);
    }
}