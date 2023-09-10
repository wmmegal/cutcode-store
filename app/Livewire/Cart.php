<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\CartItem as MCartItem;

class Cart extends Component
{
    public function deleteItem($itemId): void
    {
        $item = MCartItem::find($itemId);

        cart()->delete($item);

        $this->dispatch('count');
    }

    #[On('count')]
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.cart', [
            'items' => cart()->items(),
            'total' => cart()->total()
        ])
            ->title('Cart');
    }
}
