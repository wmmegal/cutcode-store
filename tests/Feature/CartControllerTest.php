<?php

use App\Cart\CartManager;
use App\Http\Controllers\CartController;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function PHPUnit\Framework\assertEquals;

uses(RefreshDatabase::class);

beforeEach(function () {
    CartManager::fake();
});


it('is empty cart', function () {
    get(action([CartController::class, 'index']))
        ->assertOk()
        ->assertViewIs('cart.index')
        ->assertViewHas('items', collect());
});

it('is not empty cart', function () {
    $product = Product::factory()->create();

    cart()->add($product);

    get(action([CartController::class, 'index']))
        ->assertOk()
        ->assertViewIs('cart.index')
        ->assertViewHas('items', cart()->items());
});

it('added success', function () {
    $product = Product::factory()->create();

    assertEquals(0, cart()->count());

    post(
        action([CartController::class, 'add'], $product),
        ['quantity' => 4]
    );

    assertEquals(4, cart()->count());
});

it('quantity changed', function () {
    $product = Product::factory()->create();

    cart()->add($product, 4);

    assertEquals(4, cart()->count());

    post(
        action([CartController::class, 'quantity'], cart()->items()->first()),
        ['quantity' => 2]
    );

    assertEquals(2, cart()->count());
});

it('delete success', function () {
    $product = Product::factory()->create();

    cart()->add($product, 4);

    assertEquals(4, cart()->count());

    delete(
        action([CartController::class, 'delete'], cart()->items()->first())
    );

    assertEquals(0, cart()->count());
});

it('truncate success', function () {
    $product = Product::factory()->create();

    cart()->add($product, 4);

    expect(4)->toBe(cart()->count());

    delete(
        action([CartController::class, 'truncate'])
    );

    expect(0)->toBe(cart()->count());
});
