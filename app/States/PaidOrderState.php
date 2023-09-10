<?php

namespace App\States;

class PaidOrderState extends OrderState
{
    protected array $allowedTransitions = [
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'paid';
    }

    public function humanValue(): string
    {
        return 'Paid';
    }

    public function bgColor(): string
    {
        return 'bg-purple';
    }
}
