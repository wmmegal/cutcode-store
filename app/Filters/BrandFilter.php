<?php

namespace App\Filters;

use App\Models\Brand;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BrandFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Brands';
    }

    public function key(): string
    {
        return 'brands';
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue(), function (Builder $q) {
            $q->whereIn('brand_id', $this->requestValue());
        });
    }

    public function values(): array
    {
        return Brand::has('products')
                    ->get()
                    ->pluck('title', 'id')
                    ->toArray();
    }

    public function view(): string
    {
        return 'catalog.filters.brands';
    }
}
