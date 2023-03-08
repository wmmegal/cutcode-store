<?php

use App\Jobs\ProductJsonProperties;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertNotEmpty;

uses(RefreshDatabase::class);

it('created json properties', function () {
    $queue = Queue::getFacadeRoot();

    Queue::fake([ProductJsonProperties::class]);

    $properties = Property::factory(10)->create();
    $product    = Product::factory()
                         ->hasAttached($properties, function () {
                             return ['value' => fake()->word()];
                         })
                         ->create();

    assertEmpty($product->json_properties);

    Queue::swap($queue);
    ProductJsonProperties::dispatchSync($product);

    $product->refresh();

    assertNotEmpty($product->json_properties);
});
