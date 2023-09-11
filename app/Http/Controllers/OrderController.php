<?php

namespace App\Http\Controllers;

use App\Models\Order\Order;

class OrderController extends Controller
{
    public function __invoke(Order $order)
    {
        $this->authorize('show', $order);

        return view('account.order', [
            'order' => $order,
            'orderItems' => $order->orderItems()
                ->with('product', 'optionValues.option')
                ->get()
        ]);
    }
}
