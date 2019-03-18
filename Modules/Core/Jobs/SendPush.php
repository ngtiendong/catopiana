<?php

namespace Modules\Core\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Modules\Core\Lib\PushNotification;

class SendPush implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;

    protected $deviceToken;
    protected $deviceOs;
    protected $message;
    protected $extraData;

    /**
     * SendPush constructor.
     * @param $deviceToken
     * @param $deviceOs
     * @param $message
     * @param $extraData
     */
    public function __construct($deviceToken, $deviceOs, $message, $extraData)
    {
        $this->deviceToken = $deviceToken;
        $this->deviceOs = $deviceOs;
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
            PushNotification::sendNotification($this->deviceToken, $this->deviceOs, $this->message, $this->extraData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage() . '. File: ' . $ex->getFile() . '. Line: ' . $ex->getLine());
        }
    }
}
