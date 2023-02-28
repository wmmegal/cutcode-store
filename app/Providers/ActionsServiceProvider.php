<?php

namespace App\Providers;

use App\Actions\RegisterUserAction;
use App\Contracts\RegisterUserContract;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterUserContract::class => RegisterUserAction::class
    ];
}
