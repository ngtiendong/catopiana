<?php
namespace Modules\Core\Lib\SmsService;

class Nexmo implements SmsServiceInterface
{
    protected $apiKey;
    protected $apiSecret;

    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * @param $phoneNumber
     * @param $message
     * @return array
     */
    public function sendSms($phoneNumber, $message)
    {

    }
}