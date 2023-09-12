<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Models\Order\Order;
use App\States\PendingOrderState;

class ChangeStateToPendingProcess implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        $order->status = 'pending';

        return $next($order);
    }
}
