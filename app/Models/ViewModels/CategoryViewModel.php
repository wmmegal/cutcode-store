<?php

namespace App\Models\ViewModels;

use App\Models\Category;
use App\Support\Traits\Makeable;
use Cache;

class CategoryViewModel
{
    use Makeable;

    public function onHome()
    {
        return Category::onHome()->get();
    }
}
