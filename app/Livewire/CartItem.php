<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\CartItem as MCartItem;

class CartItem extends Component
{
    public MCartItem $item;

    #[On('count.{item.id}')]
    public function updateQuantity($quantity): void
    {
        $this->item->load('optionValues.option');
        cart()->quantity($this->item, max($quantity, 1));
        $this->dispatch('count');
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.cart-item');
    }
}
