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
    public function add($product_id, $quantity, array $options = []): void
    {
        $product = Product::find($product_id);

        cart()->add($product_id, $quantity, $options);

        $this->dispatch('notify', text: 'Товар ' . $product->title . ' добавлен в корзину')
            ->to(FlashLivewireMessage::class);
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.mini-cart', [
            'count' => cart()->count(),
            'total' => cart()->total()
        ]);
    }
}
