<?php

use App\Enums\OrderStatuses;
use App\Models\Order\DeliveryType;
use App\Models\Order\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->enum('status', array_column(OrderStatuses::cases(), 'value'))
                ->default('new');

            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(DeliveryType::class)
                ->constrained();

            $table->foreignIdFor(PaymentMethod::class)
                ->constrained();

            $table->unsignedInteger('amount')
                ->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        if(!app()->isProduction()) {
            Schema::dropIfExists('orders');
        }
    }
};
