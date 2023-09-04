<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;

class MiniCart extends Component
{
    #[On('addToCart')]
    public function add($productId, $quantity, array $options = []): void
    {
        $product = Product::find($productId);

        cart()->add($productId, $quantity, $options);

        $this->dispatch('notify', text: 'Товар ' . $product->title . ' добавлен в корзину')
            ->to(FlashLivewireMessage::class);
    }

    #[On('checkProductInCart')]
    public function checkProductInCart($productId, $options = []): void
    {
        $this->dispatch('checked-product-in-cart', cart()->inCart($productId, $options));
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.mini-cart', [
            'count' => cart()->count(),
            'total' => cart()->total()
        ]);
    }
}
