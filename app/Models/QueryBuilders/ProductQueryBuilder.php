<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ProductQueryBuilder extends Builder
{
    public function onHome()
    {
        return $this->where('on_home_page', true)
                    ->orderBy('sorting')
                    ->limit(8);
    }

    public function filtered()
    {
        return $this->when(request('filters.brand'), function (Builder $q) {
            $q->whereIn('brand_id', request('filters.brand'));
        })->when(request('filters.price'), function (Builder $q) {
            $q->whereBetween('price', [
                request('filters.price.from', 0) * 100,
                request('filters.price.to', 100000) * 100,
            ]);
        });
    }

    public function sorted()
    {
        return $this->when(request('sort'), function (Builder $q) {
            $column = request()->str('sort');

            if ($column->contains(['price', 'title'])) {
                $direction = $column->contains('-') ? 'DESC' : 'ASC';

                $q->orderBy((string) $column->remove('-'), $direction);
            }
        });
    }

    public function category($category)
    {
        return $this->when($category->exists, function (Builder $q) use ($category) {
            $q->whereRelation('categories', 'id', '=', $category->id);
        });
    }

}
