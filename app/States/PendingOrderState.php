<?php

namespace App\States;

class PendingOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'pending';
    }

    public function humanValue(): string
    {
        return 'Pending';
    }

    public function bgColor(): string
    {
        return 'bg-purple';
    }
}
