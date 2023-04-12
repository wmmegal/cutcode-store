<?php

namespace App\Contracts;

use App\Models\Order\Order;

interface OrderProcessContract
{
    public function handle(Order $order, $next);
}
