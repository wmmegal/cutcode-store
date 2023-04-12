<?php

namespace App\Processes;

use App\Models\Order\Order;
use App\Support\Transaction;
use DomainException;
use Illuminate\Pipeline\Pipeline;
use Throwable;

class OrderProcess
{
    protected array $processes = [];

    public function __construct(
        protected Order $order
    )
    {
    }

    public function processes($processes): self
    {
        $this->processes = $processes;

        return $this;
    }

    /**
     * @throws Throwable
     */
    public function run()
    {
        return Transaction::run(function () {
            return app(Pipeline::class)
                ->send($this->order)
                ->through($this->processes)
                ->thenReturn();
        }, function (Order $order) {
            flash()->info('Good # ' . $order->id);
        }, function (Throwable $e) {
            throw new DomainException($e->getMessage());
        });
    }
}
