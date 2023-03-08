<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('success response', function () {
    $product = Product::factory()->create();

    get(action(ProductController::class, $product))
        ->assertViewIs('product.show')
        ->assertOk();
});
