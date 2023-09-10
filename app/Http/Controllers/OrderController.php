<?php

namespace App\Http\Controllers;

use App\Actions\NewOrderAction;
use App\Http\Requests\OrderFormRequest;
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
use DomainException;
use Illuminate\Http\RedirectResponse;
use Throwable;

class OrderController extends Controller
{
    public function index()
    {
        $items = cart()->items();

        if ($items->isEmpty()) {
            throw new DomainException('Корзина пуста');
        }

        return view('order.index', [
            'items' => $items,
            'payments' => PaymentMethod::query()->get(),
            'deliveries' => DeliveryType::query()->get(),
            'customer' => auth()->user()?->customer
        ]);
    }

    /**
     * @throws Throwable
     */
    public function handle(OrderFormRequest $request, NewOrderAction $action): RedirectResponse
    {
        $order = $action($request);

        (new OrderProcess($order))->processes([
            new CheckQuantityProcess(),
            new AssignCustomerProcess(request('customer')),
            new AssignProductsProcess(),
            new ChangeStateToPendingProcess(),
            new DecreaseProductQuantitiesProcess(),
            new CalcAmountProcess(),
            new ClearCartProcess()
        ])->run();

        return redirect()
            ->route('account.orders');
    }
}
