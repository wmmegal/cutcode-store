<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'email',
        'phone',
        'address',
        'city'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
