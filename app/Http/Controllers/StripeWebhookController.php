<?php

namespace App\Http\Controllers;

use App\Http\Middleware\VerifyStripeWebhookSignatureMiddleware;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

class StripeWebhookController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifyStripeWebhookSignatureMiddleware::class);
    }

    public function __invoke(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        if ($payload['type'] === 'checkout.session.completed') {
            $order = Order::findOrFail($payload['data']['object']['metadata']['order_id']);

            $order->update([
                'status' => $payload['data']['object']['payment_status'] === 'paid' ? 'paid' : 'pending'
            ]);
        }

        return new Response();
    }
}
