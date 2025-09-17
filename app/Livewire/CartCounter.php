<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class CartCounter extends Component
{
    #[On('cart-updated')]
    public function render()
    {
        $cart = session()->get('cart', []);
        $count = count($cart);

        return view('livewire.cart-counter', [
            'count' => $count,
        ]);
    }
}
