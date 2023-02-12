<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::createDirectory('brands');
        Storage::createDirectory('products');

        Brand::factory(20)->create();

        Category::factory(10)
            ->has(Product::factory(rand(5, 10)))
            ->create();

    }
}
