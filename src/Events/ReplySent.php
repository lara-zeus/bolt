<?php

namespace LaraZeus\Wind\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use LaraZeus\Wind\Models\Letter;

class ReplySent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Letter $letter;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Letter $letter)
    {
        $this->letter = $letter;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('zeus-wind');
    }
}
