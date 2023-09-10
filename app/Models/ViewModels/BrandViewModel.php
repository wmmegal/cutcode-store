<?php

namespace App\Models\ViewModels;

use App\Models\Brand;
use App\Support\Traits\Makeable;
use Cache;

class BrandViewModel
{
    use Makeable;

    public function onHome()
    {
        return  Brand::onHome()->get();
    }
}
