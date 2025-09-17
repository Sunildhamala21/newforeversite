<?php

namespace App\Livewire;

use App\Models\Trip;
use Livewire\Component;

class AddToCart extends Component
{
    public Trip $trip;

    public function addToCart()
    {
        $cart = session()->get('cart', []);
        $price = 0;
        if ($this->trip->people_price_range) {
            foreach ($this->trip->people_price_range as $item) {
                if ($item['from'] <= 1 && $item['to'] >= 1) {
                    $price = $item['price'];
                    break;
                }
            }
        } else {
            $price = $this->trip->offer_price;
        }
        $cart[] = [
            'trip_id' => $this->trip->id,
            'no_of_travelers' => 1,
            'start_date' => '',
            'price' => $price,
        ];
        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
