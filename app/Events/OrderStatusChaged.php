<?php

namespace App\Events;

use App\Models\Order\Order;
use App\States\OrderState;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChaged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function __construct(
        public Order $order,
        public OrderState $old,
        public OrderState $current
    )
    {
        //
    }

}
