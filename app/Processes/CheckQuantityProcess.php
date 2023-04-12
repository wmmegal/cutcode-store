<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Exceptions\OrderProcessException;
use App\Models\Order\Order;

class CheckQuantityProcess implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        foreach (cart()->items() as $item) {
            if ($item->product->quantity < $item->quantity) {
                throw new OrderProcessException('Не хватает товаров на складе');
            }
        }

        return $next($order);
    }
}
