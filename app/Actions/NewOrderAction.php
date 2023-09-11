<?php

namespace App\Actions;

use App\Contracts\RegisterUserContract;
use App\DTOs\NewUserDto;
use App\Http\Requests\CheckoutFormRequest;
use App\Models\Order\Order;

class NewOrderAction
{
    public function __invoke(CheckoutFormRequest $request): Order
    {
        $registerAction = app(RegisterUserContract::class);
        $customer = $request->get('customer');
        $user = auth()->user();

        if (!auth()->check()) {
            $user = $registerAction(NewUserDto::make(
                $customer['name'],
                $customer['email'],
                'password'
            ));
        }


        return Order::create([
            'payment_method_id' => $request->get('payment_method_id'),
            'delivery_type_id' => $request->get('delivery_type_id'),
            'user_id' => $user->id
        ]);
    }
}
