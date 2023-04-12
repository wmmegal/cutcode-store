<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use App\Models\Order\Order;

class AssignCustomerProcess implements OrderProcessContract
{
    public function __construct(protected array $customer)
    {
    }


    public function handle(Order $order, $next)
    {
        $order->orderCustomer()
              ->create($this->customer);

        return $next($order);
    }
}
