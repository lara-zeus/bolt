<?php

namespace LaraZeus\Bolt\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;

    public function __construct($response)
    {
        $this->response = $response;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('form-sent');
    }
}
