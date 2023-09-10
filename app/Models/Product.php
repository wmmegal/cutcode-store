<?php

namespace App\Models;

use App\Casts\PriceCast;
use App\Jobs\ProductJsonProperties;
use App\Models\QueryBuilders\ProductQueryBuilder;
use App\Support\Traits\Models\HasSlug;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pipeline\Pipeline;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'brand_id',
        'price',
        'thumbnail',
        'on_home_page',
        'sorting',
        'text',
        'json_properties',
        'quantity'
    ];

    protected $casts = [
        'price'           => PriceCast::class,
        'json_properties' => 'array'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Product $product) {
            ProductJsonProperties::dispatch($product)
                                 ->delay(now()->addSeconds(5));
        });
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
                    ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }
}
