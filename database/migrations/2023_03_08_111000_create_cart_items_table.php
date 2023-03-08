<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Cart::class)
                  ->constrained()
                  ->cascadeOnDelete()
                  ->cascadeOnDelete();

            $table->foreignIdFor(Product::class)
                  ->constrained()
                  ->cascadeOnDelete()
                  ->cascadeOnDelete();

            $table->unsignedBigInteger('price');
            $table->integer('quantity');
            $table->string('string_option_values')
                  ->nullable();

            $table->timestamps();
        });

        Schema::create('cart_item_option_value', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(CartItem::class)
                  ->constrained()
                  ->cascadeOnDelete()
                  ->cascadeOnDelete();

            $table->foreignIdFor(OptionValue::class)
                  ->constrained()
                  ->cascadeOnDelete()
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('cart_items');
        }
    }
};
