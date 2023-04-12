<?php

namespace App\Models\Order;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'with_address'
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];
}
