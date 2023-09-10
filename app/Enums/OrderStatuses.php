<?php

namespace App\Enums;

use App\Models\Order\Order;
use App\States\CancelledOrderState;
use App\States\NewOrderState;
use App\States\PaidOrderState;
use App\States\PendingOrderState;

enum OrderStatuses: string
{
    case New = 'new';
    case Pending = 'pending';
    case Paid = 'paid';
    case Cancelled = 'cancelled';

    public function createState(Order $order): PaidOrderState|NewOrderState|PendingOrderState|CancelledOrderState
    {
        return match ($this) {
            OrderStatuses::New => new NewOrderState($order),
            OrderStatuses::Pending => new PendingOrderState($order),
            OrderStatuses::Paid => new PaidOrderState($order),
            OrderStatuses::Cancelled => new CancelledOrderState($order),
        };
    }
}
