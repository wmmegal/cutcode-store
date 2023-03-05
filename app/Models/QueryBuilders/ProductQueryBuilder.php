<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class ProductQueryBuilder extends Builder
{
    public function onHome()
    {
        return $this->where('on_home_page', true)
                    ->orderBy('sorting')
                    ->limit(8);
    }

//    public function filtered()
//    {
//        $query = $this->newQuery();
//        $query = app(Pipeline::class)
//            ->send($this)
//            ->through(filters())
//            ->thenReturn();
//
//
//        return $this;
//    }

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
            $q->whereRelation('categories', 'categories.id', '=', $category->id);
        });
    }

}
