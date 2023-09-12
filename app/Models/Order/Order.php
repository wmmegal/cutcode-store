<?php

namespace App\Models\Order;

use App\Casts\PriceCast;
use App\Enums\OrderStatuses;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static Order|Builder query()
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'delivery_type_id',
        'payment_method_id',
        'amount',
        'status'
    ];

    protected $casts = [
        'amount' => PriceCast::class,
        'status' => OrderStatuses::class
    ];

    protected $attributes = [
        'status' => 'new'
    ];

//    public function status(): Attribute
//    {
//        return Attribute::make(
//            get: fn(string $value) => OrderStatuses::from($value)->createState($this),
//        );
//    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryType(): BelongsTo
    {
        return $this->belongsTo(DeliveryType::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function orderCustomer(): HasOne
    {
        return $this->hasOne(OrderCustomer::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
