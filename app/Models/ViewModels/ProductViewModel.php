<?php

namespace App\Models\ViewModels;

use App\Models\Product;
use App\Support\Traits\Makeable;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Product_C;

class ProductViewModel
{
    use Makeable;

    public function onHome(): _IH_Product_C|Collection|array
    {
        return Product::onHome()->get();
    }
}
