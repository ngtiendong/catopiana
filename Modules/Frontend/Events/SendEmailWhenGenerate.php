<?php

namespace Modules\Frontend\Events;

use Illuminate\Queue\SerializesModels;

class SendEmailWhenGenerate
{
    use SerializesModels;
    public $customer;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
