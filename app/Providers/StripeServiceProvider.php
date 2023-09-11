<?php

namespace App\Providers;

use App\PaymentMethods\StripePayment;
use Illuminate\Support\ServiceProvider;
class StripeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        app()->bind('stripe', function () {
            return new StripePayment();
        });
    }

    public function boot(): void
    {

    }
}
