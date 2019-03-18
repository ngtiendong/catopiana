<?php

namespace Modules\Core\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Modules\Core\Lib\PushNotification;

class SendPushMulti implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;

    protected $deviceTokens;
    protected $message;
    protected $extraData;

    /**
     * SendPush constructor.
     * @param $deviceTokens
     * @param $message
     * @param $extraData
     */
    public function __construct($deviceTokens, $message, $extraData)
    {
        $this->deviceTokens = $deviceTokens;
        $this->message = $message;
        $this->extraData = $extraData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            PushNotification::sendMultiDevices($this->deviceTokens, $this->message, $this->extraData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage() . '. File: ' . $ex->getFile() . '. Line: ' . $ex->getLine());
        }
    }
}
