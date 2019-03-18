<?php
namespace Modules\Core\Lib\SmsService;

interface SmsServiceInterface
{
    public function sendSms($phoneNumber, $message);
}