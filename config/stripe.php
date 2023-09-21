<?php
return [
    'secret' => env('STRIPE_SECRET_KEY'),
    'webhook' => [
        'secret' => env('STRIPE_WEBHOOK_SECRET')
    ]
];
