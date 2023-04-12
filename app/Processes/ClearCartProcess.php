<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Models\Order\Order;

class ClearCartProcess implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        cart()->truncate();

        return $next($order);
    }
}
