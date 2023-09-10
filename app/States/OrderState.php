<?php

namespace App\States;

use App\Events\OrderStatusChaged;
use App\Models\Order\Order;
use InvalidArgumentException;

abstract class OrderState
{
    protected array $allowedTransitions = [];
    public function __construct(
        protected Order $order
    ) {
    }
    abstract public function canBeChanged(): bool;
    abstract public function value(): string;
    abstract public function humanValue(): string;
    abstract public function bgColor(): string;

    public function transitionTo(OrderState $state): void
    {
        if ( ! $this->canBeChanged()) {
            throw new InvalidArgumentException('Status can`t be changed');
        }

        if ( ! in_array(get_class($state), $this->allowedTransitions)) {
            throw new InvalidArgumentException(
                "No transition for {$this->order->status->value()} to {$state->value()}"
            );
        }

        $this->order->updateQuietly([
            'status' => $state->value()
        ]);

        event(new OrderStatusChaged(
            $this->order,
            $this->order->status,
            $state,
        ));
    }
}
