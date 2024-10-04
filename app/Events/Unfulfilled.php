<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Unfulfilled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $lineitemId;
    public $dropshipNo;
    public $shiptype;
    public $variantId;
    public $productTitle;

    public function __construct($lineitemId, $dropshipNo, $shiptype, $variantId, $productTitle)
    {
        $this->lineitemId = $lineitemId;
        $this->dropshipNo = $dropshipNo;
        $this->shiptype = $shiptype;
        $this->variantId = $variantId;
        $this->productTitle = $productTitle;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('unfulfills');
    }

    public function broadcastAs()
    {
        return 'unfulfilled';
    }
}
