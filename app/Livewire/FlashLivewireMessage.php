<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class FlashLivewireMessage extends Component
{
    public string $message;
    public string $class;

    #[On('notify')]
    public function show($text, $type = 'info'): void
    {
        $this->class = config("flash.$type");
        $this->message = $text;
    }

    #[On('hideNotify')]
    public function hide(): void
    {
        $this->message = '';
    }
}
