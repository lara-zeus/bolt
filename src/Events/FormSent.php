<?php

namespace LaraZeus\Bolt\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormSent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $response;

    public $item;

    public $data;

    public function __construct($response, $item, $data)
    {
        $this->response = $response;
        $this->item = $item;
        $this->data = $data;
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
