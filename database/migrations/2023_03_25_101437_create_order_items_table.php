<?php

use App\Models\OptionValue;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Order::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();


            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedInteger('price');

            $table->unsignedInteger('quantity');

            $table->string('string_option_values')
                ->nullable();

            $table->timestamps();
        });


        Schema::create('order_item_option_value', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(OrderItem::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(OptionValue::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        if(!app()->isProduction()) {
            Schema::dropIfExists('order_item_option_value');
            Schema::dropIfExists('order_items');
        }
    }
};
