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
        return Cache::rememberForever('categories_on_home', function () {
            return Category::onHome()->get();
        });
    }
}
