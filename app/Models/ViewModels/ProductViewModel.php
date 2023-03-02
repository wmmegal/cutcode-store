<?php

namespace App\Models\ViewModels;

use App\Models\Product;
use App\Support\Traits\Makeable;
use Cache;

class ProductViewModel
{
    use Makeable;

    public function onHome()
    {
        return Cache::rememberForever('products_on_home', function () {
            return Product::onHome()->get();
        });
    }
}
