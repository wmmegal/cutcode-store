<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;

class DecreaseProductQuantitiesProcess implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        foreach (cart()->items() as $item) {
            $item->product()->update([
                'quantity' => DB::raw('quantity -' . $item->quantity)
            ]);
        }

        return $next($order);
    }
}
