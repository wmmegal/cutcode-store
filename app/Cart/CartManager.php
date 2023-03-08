<?php

namespace App\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\ValueObjects\Price;
use Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CartManager
{

    public function __construct(
        protected IdentityStorageContract $identityStorage
    ) {
    }

    public static function fake(): void
    {
        app()->bind(IdentityStorageContract::class, FakeIdentityStorage::class);
    }

    public function instance()
    {
        return Cache::remember($this->cacheKey(), now()->addHour(), function () {
            return Cart::with('cartItems')
                       ->where('storage_id', $this->identityStorage->get())
                       ->when(auth()->check(), function (Builder $q) {
                           $q->orWhere('user_id', auth()->id());
                       })
                       ->first() ?? false;
        });
    }

    public function updateSessionId(string $old, string $current): void
    {
        Cart::where('storage_id', $old)
            ->update($this->storedData($current));
    }

    public function add(Product $product, int $quantity = 1, array $optionValues = []): Cart
    {
        $cart = Cart::updateOrCreate([
            'storage_id' => $this->identityStorage->get()
        ], $this->storedData($this->identityStorage->get()));

        $cartItem = $cart->cartItems()
                         ->updateOrCreate([
                             'product_id'           => $product->getKey(),
                             'string_option_values' => $this->stringedOptionValues($optionValues)
                         ], [
                             'price'                => $product->price,
                             'quantity'             => $quantity,
                             'string_option_values' => $this->stringedOptionValues($optionValues)
                         ]);

        $cartItem->optionValues()->sync($optionValues);
        $this->forgetCache();

        return $cart;
    }

    public function quantity(CartItem $item, int $quantity = 1): void
    {
        $item->update([
            'quantity' => $quantity
        ]);

        $this->forgetCache();
    }

    public function delete(CartItem $item): void
    {
        $item->delete();
        $this->forgetCache();
    }

    public function truncate(): void
    {
        if ($this->instance()) {
            $this->instance()->delete();
        }

        $this->forgetCache();
    }

    public function items(): Collection
    {
        if ( ! $this->instance()) {
            return collect();
        }

        return CartItem::with(['product', 'optionValues.option'])
                       ->whereBelongsTo($this->instance())
                       ->get();
    }

    public function cartItems(): Collection
    {
        if ( ! $this->instance()) {
            return collect();
        }

        return $this->instance()->cartItems;
    }

    public function count()
    {
        return $this->cartItems()->sum(function (CartItem $item) {
            return $item->quantity;
        });
    }

    public function total(): Price
    {
        return Price::make(
            $this->cartItems()->sum(function (CartItem $item) {
                return $item->amount->raw();
            })
        );
    }

    private function storedData(string $id): array
    {
        $data = [
            'storage_id' => $id
        ];

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }

    private function stringedOptionValues(array $optionValues = []): string
    {
        sort($optionValues);

        return implode(';', $optionValues);
    }

    protected function cacheKey(): string
    {
        return str('cart_'.$this->identityStorage->get())
            ->slug('_')
            ->value();
    }

    protected function forgetCache(): void
    {
        Cache::forget($this->cacheKey());
    }
}
