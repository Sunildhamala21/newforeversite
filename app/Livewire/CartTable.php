<?php

namespace App\Livewire;

use App\Models\Trip;
use Carbon\Carbon;
use Livewire\Component;

class CartTable extends Component
{
    public array $noOfTravelers = [];

    public array $startDates = [];

    public array $endDates = [];

    public bool $canProceed = false;

    public function mount()
    {
        $cart = session()->get('cart', []);
        $this->noOfTravelers = array_map(function ($item) {
            return $item['no_of_travelers'];
        }, $cart);
    }

    public function removeFromCart($index)
    {
        $cart = session()->get('cart', []);
        array_splice($cart, $index, 1);
        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
    }

    public function decreaseTravelers($index)
    {
        $this->noOfTravelers[$index] = max($this->noOfTravelers[$index] - 1, 1);
        $this->updateCart();
    }

    public function increaseTravelers($index)
    {
        $this->noOfTravelers[$index] = $this->noOfTravelers[$index] + 1;
        $this->updateCart();
    }

    public function updatedStartDates()
    {
        $this->updateCart();
    }

    private function updateCart()
    {
        $cart = session()->get('cart', []);
        $cart = array_map(function ($item, $index) {
            $item['no_of_travelers'] = $this->noOfTravelers[$index];
            if (isset($this->startDates[$index])) {
                $item['start_date'] = $this->startDates[$index];
            }

            return $item;
        }, $cart, array_keys($cart));
        session()->put('cart', $cart);
    }

    public function render()
    {
        $cart = session()->get('cart', []);

        $this->canProceed = true;

        $cart = array_map(function ($item, $index) {
            $item['trip'] = Trip::findOrFail($item['trip_id']);
            $item['start_date'] = $item['start_date'] ? Carbon::parse($item['start_date'])->toDateString() : '';
            if ($item['start_date']) {
                $item['end_date'] = Carbon::parse($item['start_date'])->addDays($item['trip']->duration - 1)->format('M d, Y');
            } else {
                $this->canProceed = false;
            }
            $price = 0;
            if ($item['trip']->people_price_range) {
                foreach ($item['trip']->people_price_range as $priceItem) {
                    if ($priceItem['from'] <= $this->noOfTravelers[$index] && $priceItem['to'] >= $this->noOfTravelers[$index]) {
                        $price = $priceItem['price'];
                        break;
                    }
                }
            } else {
                $price = $item['trip']->offer_price;
            }
            $item['price'] = (int) $price * $this->noOfTravelers[$index];

            return $item;
        }, $cart, array_keys($cart));

        $cartTotal = array_reduce($cart, function ($total, $item) {
            return $total + $item['price'];
        }, 0);

        return view('livewire.cart-table', ['cart' => $cart, 'cartTotal' => $cartTotal]);
    }
}
