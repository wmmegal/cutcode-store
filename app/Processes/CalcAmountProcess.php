<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Models\CartItem;
use App\Models\Order\Order;

class CalcAmountProcess  implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        $order->update([
            'amount' => cart()->items()->sum(function (CartItem $item) {
                return $item->amount->raw();
            })
        ]);

        return $next($order);
    }
}
