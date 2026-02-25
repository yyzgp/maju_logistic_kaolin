<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class SendOnlineStatus implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $is_online;
    public $driver_id;
    public $name;

    public function __construct($is_online, $driver_id,$name)
    {
        $this->is_online      = $is_online;
        $this->driver_id   = $driver_id;
        $this->name = $name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('online-status');
    }

    public function broadcastWith(): array
    {
        return [
            'driver_id' => $this->driver_id,
            'is_online' => $this->is_online,
            'name' => $this->name
        ];
    }
}
