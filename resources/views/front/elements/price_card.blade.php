<div x-data="{ isGroupDiscountsShown: true }" class="px-8 py-6 mb-6 text-gray-600 bg-white border rounded-lg price-card border-primary">

    <div class="flex justify-between gap-4 mb-6">
        <div>
            <div class="h-6"></div>
            <div class="mb-1 text-sm">
                Days
            </div>
            <span class="text-xl font-semibold">{{ $trip->duration }}</span>
        </div>
        @if ($trip->cost)
            <div>
                <div class="h-6"></div>
                <div class="mb-1 text-sm">
                    Save
                </div>
                <span class="text-xl">US$ {{ number_format($trip->cost - $trip->offer_price) }}</span>
            </div>
            <div>
                <div
                    class="h-6 px-3 py-1 mb-1 text-sm tracking-wide text-center text-white uppercase bg-red-600 rounded-xs">
                    Limited offer</div>
                <div class="relative mb-1 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="absolute w-5 h-5 -translate-x-1 text-accent right-full" viewBox="0 0 16 16">
                        <path
                            d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z" />
                    </svg>
                    From
                    @if ($trip->offer_price)
                        <s class="text-red-500">
                            US$ {{ number_format($trip->cost) }}
                        </s>
                    @endif
                </div>

                <div>
                    <span class="text-xl font-semibold">US$
                        {{ $trip->offer_price ? number_format($trip->offer_price) : number_format($trip->cost) }}</span>
                </div>
                @if ($trip->people_price_range)
                    <button x-on:click="isGroupDiscountsShown=!isGroupDiscountsShown" class="text-sm text-primary"
                        x-text="`${isGroupDiscountsShown ? 'Hide' : 'Show'} Group Discounts`"></button>
                @endif
            </div>
        @endif
    </div>
    <ul class="mb-4 text-sm">
        <li class="flex gap-1 mb-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="shrink-0 w-6 h-6 -mt-1 text-green-500" viewBox="0 0 16 16">
                <path
                    d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
            </svg>
            Best price guaranteed
        </li>
        <li class="flex gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="shrink-0 w-6 h-6 -mt-1 text-green-500" viewBox="0 0 16 16">
                <path
                    d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
            </svg>
            No booking fees
        </li>
        <li class="flex gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="shrink-0 w-6 h-6 -mt-1 text-green-500" viewBox="0 0 16 16">
                <path
                    d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
            </svg>
            Book Now, Pay Later
        </li>
    </ul>
    @if ($trip->people_price_range)
        <div class="mt-6 font-semibold">Group Discounts Available</div>
        <ul class="mt-4 space-y-2 text-sm leaders">
            @foreach ($trip->people_price_range as $item)
                <li>
                    <span class="">{{ $item['from'] }}
                        {{ $item['to'] != '' ? ' - ' . $item['to'] : '' }} Person</span>
                    <span class="font-semibold"> US${{ number_format($item['price']) }}</span>
                </li>
            @endforeach
        </ul>
    @endif
    <div class="mb-2 text-center">
        <div class="flex gap-4 mt-4 mb-4">
            <a href="{{ route('front.trips.booking', $trip->slug) }}"
                class="block w-full px-4 py-3 text-lg tracking-wide text-center text-white uppercase bg-green-600 rounded-lg hover:bg-green-700">Book
                Now</a>
            <livewire:add-to-cart :trip="$trip" />
        </div>
        <a href="{{ route('front.plantrip.createfortrip', $trip->slug) }}"
            class="inline-flex items-center px-4 py-3 mb-2 tracking-wide text-center uppercase border rounded-lg border-primary text-primary hover:light">
            Plan My Trip
        </a>
    </div>
    <div class="flex justify-between gap-4">
        <div>
            <div class="mb-2 text-xs text-gray-400">Share</div>
            <div class="flex justify-center gap-2">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('front.trips.show', $trip) }}"
                    class="mr-2 text-gray-400 hover:text-primary" aria-label="Share on Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="w-5 h-5" viewBox="0 0 16 16">
                        <path
                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                    </svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ route('front.trips.show', $trip) }}&text="
                    class="mr-2 text-gray-400 hover:text-primary" aria-label="Share on Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="w-5 h-5" viewBox="0 0 16 16">
                        <path
                            d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                    </svg>
                </a>
                <a href="{{ Setting::get('instagram') }}" class="text-gray-400 hover:text-primary"
                    aria-label="Share on Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="w-5 h-5" viewBox="0 0 16 16">
                        <path
                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="text-center">
            <div class="mb-1 text-xs text-gray-400">Print</div>
            <a href="{{ route('front.trips.print', ['slug' => $trip->slug]) }}"
                class="text-gray-400 hover:text-primary" aria-label="Print">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="w-5 h-5" viewBox="0 0 16 16">
                    <path
                        d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1" />
                    <path
                        d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                </svg>
            </a>
        </div>
    </div>
</div>
