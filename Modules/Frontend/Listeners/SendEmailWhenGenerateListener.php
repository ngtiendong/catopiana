<?php

namespace Modules\Frontend\Listeners;

use Modules\Frontend\Events\SendEmailWhenGenerate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Frontend\Emails\GenarateAccount;
use Illuminate\Support\Facades\Mail;

class SendEmailWhenGenerateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param SendEmailWhenGenerate $event
     * @return void
     */
    public function handle(SendEmailWhenGenerate $event)
    {
        $customer = $event->customer;
        Mail::to($customer['email'])->send(new GenarateAccount($customer));
    }
}
