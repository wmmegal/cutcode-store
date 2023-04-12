<?php

namespace App\Actions;

use App\Contracts\RegisterUserContract;
use App\DTOs\NewUserDto;
use App\Http\Requests\OrderFormRequest;
use App\Models\Order\Order;

class NewOrderAction
{
    public function __invoke(OrderFormRequest $request): Order
    {
        $registerAction = app(RegisterUserContract::class);
        $customer       = $request->get('customer');

        if ($request->boolean('create_account')) {
            $registerAction(NewUserDto::make(
                $customer['first_name'].' '.$customer['last_name'],
                $customer['email'],
                $request->get('password')
            ));
        }

        return Order::create([
                        'payment_method_id' => $request->get('payment_method_id'),
                        'delivery_type_id'  => $request->get('delivery_type_id')
                    ]);
    }
}
