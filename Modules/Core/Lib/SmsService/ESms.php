<?php
namespace Modules\Core\Lib\SmsService;

class ESms implements SmsServiceInterface
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
     * @param int $smsType
     * @param bool $isSandbox
     * @return array
     */
    public function sendSms($phoneNumber, $message, $isSandbox = false, $smsType = 4)
    {
        $sendContent=urlencode($message);
        $data = 'http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone='. $phoneNumber .'&ApiKey=' . $this->apiKey . '&SecretKey=' . $this->apiSecret . '&Content=' . $sendContent . '&SmsType=' . $smsType;

        if ($isSandbox) {
            $data .= '&Sandbox=1';
        }

        $curl = curl_init($data);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

        $obj = json_decode($result,true);
        dump($obj);
        if($obj['CodeResult']==100) {
            return ['success' => true, 'sms_id' => $obj['SMSID']];
        } else {
            return ['success' => false, 'message' => $obj['ErrorMessage']];
        }
    }
}