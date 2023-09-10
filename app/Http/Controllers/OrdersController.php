<?php

namespace App\Http\Controllers;


class OrdersController extends Controller
{
    public function __invoke()
    {
        return view('account.orders', [
            'orders' => auth()->user()->orders
        ]);
    }
}
