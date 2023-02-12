<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    public static int $i = 1;

    protected static function bootHasSlug()
    {
        static::creating(function (Model $model) {
            $model->slug = $model->slug ?? self::generateSlug($model, str($model->{self::slugFrom()})->slug());
        });
    }

    public static function generateSlug($model, $slug)
    {
        if ( ! $model::query()->whereSlug($slug)->value('slug')) {
            return $slug;
        }

        self::$i++;

        return self::generateSlug($model, $slug.'-'.self::$i);
    }

    public static function slugFrom()
    {
        return 'title';
    }
}
