<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_types', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->unsignedBigInteger('price')
                ->default(0);

            $table->boolean('with_address')
                ->default(false);

            $table->timestamps();
        });

        DB::table('delivery_types')->insert(['title' => 'Pickup']);
        DB::table('delivery_types')->insert([
            'title' => 'By courier',
            'with_address' => true
        ]);
    }

    public function down(): void
    {
        if(!app()->isProduction()) {
            Schema::dropIfExists('delivery_types');
        }
    }
};
