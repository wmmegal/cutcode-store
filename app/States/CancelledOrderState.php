<?php

namespace App\States;

class CancelledOrderState extends OrderState
{
    protected array $allowedTransitions = [

    ];

    public function canBeChanged(): bool
    {
        return false;
    }

    public function value(): string
    {
        return 'cancelled';
    }

    public function humanValue(): string
    {
        return 'Cancelled';
    }

    public function bgColor(): string
    {
        return 'bg-pink';
    }

    public function __toString(): string
    {
        return 'cancelled';
    }
}
