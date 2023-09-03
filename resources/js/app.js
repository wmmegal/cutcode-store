import './bootstrap';
import './main';

import.meta.glob([
    '../images/**',
    '../fonts/**'
])

import {Livewire, Alpine} from '../../vendor/livewire/livewire/dist/livewire.esm';
import addToCart from "./modules/addToCart";

Alpine.data('addToCart', addToCart)

Livewire.start()
