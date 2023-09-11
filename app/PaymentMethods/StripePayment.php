<?php

namespace App\PaymentMethods;

use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use Stripe\StripeClient;

class StripePayment
{
    protected StripeClient $stripeClient;

    public function __construct()
    {
        $this->stripeClient = new StripeClient(config('stripe.secret'));
    }

    public function handle(Order $order): string
    {
        $checkoutSession =  $this->stripeClient->checkout->sessions->create([
            'line_items' => $order->orderItems->map(function (OrderItem $orderItem) {
                return [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $orderItem->product->title,
                        ],
                        'unit_amount' => $orderItem->price->raw(),
                    ],
                    'quantity' => $orderItem->quantity,
                ];
            })->toArray(),
            'mode' => 'payment',
            'success_url' => route('account.orders'),
            'cancel_url' => route('account.orders'),
        ]);

        return $checkoutSession->url;
    }
}
