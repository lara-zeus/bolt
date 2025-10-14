<?php

namespace LaraZeus\Bolt\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use LaraZeus\Bolt\Models\Response;

class FormSent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel | PrivateChannel | array
    {
        return new PrivateChannel('form-sent');
    }
}
