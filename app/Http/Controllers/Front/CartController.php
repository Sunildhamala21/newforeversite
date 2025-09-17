<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Setting;
use App\Http\Controllers\Controller;
use App\Mail\BookingCreated;
use App\Models\Booking;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return view('front.cart.index');
    }

    public function checkout(): View|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $cart = array_map(function ($item, $index) {
            $item['trip'] = Trip::findOrFail($item['trip_id']);
            $item['start_date'] = $item['start_date'] ? Carbon::parse($item['start_date'])->format('M d, Y') : '';
            if ($item['start_date']) {
                $item['end_date'] = Carbon::parse($item['start_date'])->addDays($item['trip']->duration - 1)->format('M d, Y');
            }
            $price = 0;
            if ($item['trip']->people_price_range) {
                foreach ($item['trip']->people_price_range as $priceItem) {
                    if ($priceItem['from'] <= $item['no_of_travelers'] && $priceItem['to'] >= $item['no_of_travelers']) {
                        $price = $priceItem['price'];
                        break;
                    }
                }
            } else {
                $price = $item['trip']->offer_price;
            }
            $item['price'] = (int) $price * $item['no_of_travelers'];

            return $item;
        }, $cart, array_keys($cart));

        $cartTotal = array_reduce($cart, function ($total, $item) {
            return $total + $item['price'];
        }, 0);

        return view('front.cart.checkout', ['cart' => $cart, 'cartTotal' => $cartTotal]);
    }

    public function storeCheckout(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'string|required',
            'middle_name' => 'string|nullable',
            'last_name' => 'string|required',
            'email' => 'email|required',
            'phone' => 'string|required',
            'gender' => 'string|nullable',
            'country' => 'string|required',
            'message' => 'string|nullable',
            'pay' => 'string|nullable',
            'tnc' => 'required|accepted',
        ], [
            'tnc' => 'You must accept the terms and conditions',
        ]);

        unset($validated['tnc']);

        $booking = Booking::create([...$validated, 'type' => 'cart', 'amount' => 0]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $cart = array_map(function ($item) use ($booking) {
            $trip = Trip::findOrFail($item['trip_id']);
            $start_date = Carbon::parse($item['start_date']);
            $end_date = Carbon::parse($item['start_date'])->addDays($trip->duration - 1);
            $price = 0;
            if ($trip->people_price_range) {
                foreach ($trip->people_price_range as $priceItem) {
                    if ($priceItem['from'] <= $item['no_of_travelers'] && $priceItem['to'] >= $item['no_of_travelers']) {
                        $price = $priceItem['price'];
                        break;
                    }
                }
            } else {
                $price = $trip->offer_price;
            }
            $item['price'] = (int) $price * $item['no_of_travelers'];

            $booking->trips()->attach($trip, [
                'no_of_travelers' => $item['no_of_travelers'],
                'start_date' => $start_date,
                'end_date' => $end_date,
                'price' => $item['price'],
            ]);

            return $item;
        }, $cart);

        $booking->update([
            'amount' => array_reduce($cart, function ($total, $item) {
                return $total + $item['price'];
            }, 0),
        ]);

        session()->forget('cart');

        Mail::to(Setting::get('email'))->send(new BookingCreated($booking));

        return to_route('cart.index')->with('success_message', 'Booking created successfully');
    }
}
