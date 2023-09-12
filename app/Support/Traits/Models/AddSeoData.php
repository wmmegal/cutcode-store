<?php

namespace App\Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Leeto\Seo\Models\Seo;

trait AddSeoData
{
    protected static function bootAddSeoData(): void
    {
        static::created(function (Model $model) {
            Seo::create([
                'url' => route('product', $model),
                'title' => $model->title,
            ]);
        });
    }
}
