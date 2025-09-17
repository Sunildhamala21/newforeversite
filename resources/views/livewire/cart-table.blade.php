<div class="max-w-5xl px-4 py-20 mx-auto md:px-10">
    <h1 class="mb-10 text-xl font-semibold text-center">Cart</h1>
    @if ($cart)
        <div class="overflow-x-scroll">
            <table class="table w-full overflow-hidden text-sm table-striped rounded-xl md:text-base">
                <thead>
                    <tr class="border-b bg-slate-100 text-primary">
                        <th class="py-2" colspan="2">Trip</th>
                        <th class="py-2">No of travelers</th>
                        <th class="py-2 whitespace-nowrap">Start Date</th>
                        <th class="py-2">Price</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $index => $cartItem)
                        <tr wire:key="{{ $index }}" class="border-b">
                            <td class="p-2 min-w-20">
                                <img src="{{ $cartItem['trip']->thumbImageUrl }}" alt="{{ $cartItem['trip']->name }}" class="rounded-sm size-20">
                            </td>
                            <td class="p-2 text-primary">
                                <a href="{{ $cartItem['trip']->link }}">{{ $cartItem['trip']->name }} - {{ $cartItem['trip']->duration }} days</a>
                            </td>
                            <td class="p-2 align-top">
                                <div class="relative w-28 md:w-36">
                                    <button class="absolute -translate-y-1/2 rounded-l size-8 md:size-10 top-1/2 left-px bg-slate-100 hover:bg-slate-200"
                                            wire:click="decreaseTravelers({{ $index }})">-</button>
                                    <input type="number" wire:model.live="noOfTravelers.{{ $index }}" min="1" max="12"
                                           class="w-full text-center border-2 rounded-sm border-slate-200">
                                    <button class="absolute -translate-y-1/2 rounded-r size-8 md:size-10 top-1/2 right-px bg-slate-100 hover:bg-slate-200"
                                            wire:click="increaseTravelers({{ $index }})">+</button>
                                </div>
                            </td>
                            <td class="p-2 align-top">
                                <div wire:ignore>
                                    <input type="text" class="w-full border-2 rounded-sm fp border-slate-200 min-w-40" placeholder="Select start date"
                                           data-default-date="{{ $cartItem['start_date'] }}" wire:model.live="startDates.{{ $index }}" />
                                </div>
                                @isset($cartItem['end_date'])
                                    <span class="text-sm">ends {{ $cartItem['end_date'] }}</span>
                                @endisset
                            </td>
                            <td class="p-2 text-right">US$ {{ number_format($cartItem['price']) }}</td>
                            <td class="p-2">
                                <form wire:submit="removeFromCart({{ $index }})">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 text-red-500"
                                             viewBox="0 0 16 16">
                                            <path
                                                  d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-slate-100">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="p-2 font-semibold text-right text-primary">Total</td>
                        <td class="p-2 text-right">US$ {{ number_format($cartTotal) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="mt-10 text-right">
            @if ($canProceed)
                <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
            @else
                <a class="cursor-not-allowed btn btn-muted">Proceed to Checkout</a>
            @endif
        </div>
    @else
        No items in cart
    @endif
</div>
@push('scripts')
    @vite(['resources/js/cart.js'])
@endpush
