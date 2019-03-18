<?php

namespace Modules\Core\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;

class SendSms implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;

    protected $phoneNumber;
    protected $content;

    /**
     * SendSms constructor.
     * @param $phoneNumber
     * @param $content
     */
    public function __construct($phoneNumber, $content)
    {
        $this->phoneNumber = $phoneNumber;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $service = new \Modules\Core\Lib\SendSMS();
            $service->sendSms($this->phoneNumber, $this->content);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage() . '. File: ' . $ex->getFile() . '. Line: ' . $ex->getLine());
        }
    }
}
