<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDeleteRequest;
use App\Models\Order\Order;

class OrderDeleteController extends Controller
{
    public function __invoke(OrderDeleteRequest $request, Order $order)
    {
        flash()->info('Order #' . $order->id . ' is deleted');

        $order->delete();


        return back();
    }
}
