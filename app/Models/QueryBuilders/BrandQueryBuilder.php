<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class BrandQueryBuilder extends Builder
{
    public function onHome()
    {
        return $this->where('on_home_page', true)
                    ->orderBy('sorting')
                    ->limit(6);
    }
}
