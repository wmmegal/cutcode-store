<?php

use App\Http\Controllers\HomeController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('success response', function () {
    $data = [
        'on_home_page' => true,
        'sorting'      => 999
    ];

    Product::factory(5)->create($data);
    Category::factory(5)->create($data);
    Brand::factory(5)->create($data);

    $data['sorting'] = 1;
    $product         = Product::factory()->create($data);
    $category        = Category::factory()->create($data);
    $brand           = Brand::factory()->create($data);

    get(action(HomeController::class))
        ->assertOk()
        ->assertViewHas('products.0', $product)
        ->assertViewHas('categories.0', $category)
        ->assertViewHas('brands.0', $brand);
});
