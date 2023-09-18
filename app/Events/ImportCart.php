<?php

namespace App\Events;

use App\Models\HangHoa;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportCart implements ShouldBroadcast
{
    public $sanPham;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(HangHoa $sanPham)
    {
        $this->sanPham = $sanPham;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        // return [
        //     new PrivateChannel('channel-name'),
        // ];
        return ["Import"];
    }

    public function broadcastAs()
    {
        // return [
        //     new PrivateChannel('channel-name'),
        // ];
        return ["Add-item"];
    }
}
