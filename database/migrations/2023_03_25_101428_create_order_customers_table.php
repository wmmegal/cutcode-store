<?php

use App\Models\Order\Order;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class);;

            $table->string('name')
                ->nullable();

            $table->bigInteger('phone')
                ->nullable();

            $table->string('email')
                ->nullable();

            $table->string('city')
                ->nullable();

            $table->string('address')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        if(!app()->isProduction()) {
            Schema::dropIfExists('order_customers');
        }
    }
};
