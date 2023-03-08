<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CartItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cart_id'              => $this->faker->randomNumber(),
            'product_id'           => $this->faker->randomNumber(),
            'price'                => $this->faker->randomNumber(),
            'quantity'             => $this->faker->randomNumber(),
            'string_option_values' => $this->faker->word(),
            'created_at'           => Carbon::now(),
            'updated_at'           => Carbon::now(),
        ];
    }
}
