<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Models\CartItem;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;

class AssignProductsProcess implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        $orderItems = $order->orderItems()
            ->createMany(
                cart()->items()->map(function (CartItem $item) {
                    return [
                        'product_id' => $item->product_id,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'string_option_values' => $item->string_option_values
                    ];
                })->toArray()
            );

        foreach ($orderItems as $orderItem) {
            if ($orderItem->string_option_values) {
                $orderItem->optionValues()->sync(explode(';', $orderItem->string_option_values));
            }
        }

        return $next($order);
    }
}
