<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        Log::info(print_r($payload, true));
    }
}
