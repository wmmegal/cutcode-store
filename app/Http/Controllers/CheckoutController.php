<?php

namespace App\Http\Controllers;

use App\Actions\NewOrderAction;
use App\Http\Requests\CheckoutFormRequest;
use App\Models\Order\DeliveryType;
use App\Models\Order\PaymentMethod;
use App\Processes\AssignCustomerProcess;
use App\Processes\AssignProductsProcess;
use App\Processes\CalcAmountProcess;
use App\Processes\ChangeStateToPendingProcess;
use App\Processes\CheckQuantityProcess;
use App\Processes\ClearCartProcess;
use App\Processes\DecreaseProductQuantitiesProcess;
use App\Processes\OrderProcess;
use App\Processes\PaymentProcess;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Throwable;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = cart()->items();

        if ($items->isEmpty()) {
            throw new DomainException('Корзина пуста');
        }

        return view('checkout.index', [
            'items' => $items,
            'payments' => PaymentMethod::query()->get(),
            'deliveries' => DeliveryType::query()->get(),
            'customer' => auth()->user()?->customer
        ]);
    }

    /**
     * @throws Throwable
     */
    public function handle(CheckoutFormRequest $request, NewOrderAction $action): RedirectResponse
    {
        $order = $action($request);
        $redirect = 'account.orders';

        (new OrderProcess($order))->processes([
            new CheckQuantityProcess(),
            new AssignCustomerProcess(request('customer')),
            new AssignProductsProcess(),
            new ChangeStateToPendingProcess(),
            new DecreaseProductQuantitiesProcess(),
            new CalcAmountProcess(),
            new ClearCartProcess(),
        ])->run();

        if ($order->paymentMethod->redirect_to_pay) {
            $order->load('orderItems.product');
            $redirect = app(strtolower($order->paymentMethod->title))->handle($order);
        }

        return redirect($redirect);
    }
}
