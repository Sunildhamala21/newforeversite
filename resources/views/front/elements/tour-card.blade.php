<div class="flex flex-col bg-white shadow-md tour">
    <div class="top">
        <a href="{{ route('front.trips.show', $tour) }}">
            <img src="{{ $tour->mediumImageUrl }}" alt="{{ $tour->name }}" width="400" height="250" loading="lazy"
                class="object-cover">
        </a>
        <div class="top__overlay">
            <div class="flex gap-2 location">
                @if ($tour->location)
                    <svg class="w-4 h-4">
                        <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#locationmarker" />
                    </svg>
                    <span><?= $tour->location ?></span>
                @endif
            </div>

            <div>
                <span class="text-sm font-semibold">Difficulty:</span>
                <span class="ml-1">{{ $tour->difficulty }}</span>
            </div>
        </div>
    </div>
    <div class="offer bg-accent text-dark">{{ $tour->best_value }}</div>
    <div class="flex flex-col justify-between bottom flex-grow-1">
        <div class="flex flex-col p-4 flex-grow-1">

            <div class="flex justify-between">
                {{-- Activity badge --}}
                <div class="flex items-center justify-between gap-4 mb-2">
                    <span class="inline-block px-2 py-1 text-xs rounded-full bg-light">
                        {{ $tour->trip_activity_type }}
                    </span>
                </div>
                @if ($tour->trip_reviews->count() > 0)
                    <div class="flex items-center justify-center gap-2">
                        <div class="flex items-center gap-1 text-accent font-semibold">
                            <svg class="size-5">
                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#star" />
                            </svg>
                            {{ number_format($tour->trip_reviews->avg('rating'), 1) }}
                        </div>
                        <span class="text-xs">({{ $tour->trip_reviews->count() }})</span>
                    </div>
                @endif
            </div>

            {{-- Tour Name --}}
            <a href="{{ route('front.trips.show', $tour) }}" class="mb-4 flex-grow-1">
                <div>
                    <span class="mb-2 text-2xl text-gray-600 font-display">{{ $tour->name }}</span> -
                    <span> {{ $tour->duration }} {{ $tour->duration > 1 ? 'days' : 'day' }}</span>
                </div>
            </a>

            {{-- Action Buttons --}}
            <div class="flex items-end justify-between">

                {{-- Price --}}
                @if ($tour->cost)
                    <div class="relative price">
                        <div class="mr-2 text-gray-500">
                            <span class="text-sm">From</span>
                            @if ($tour->offer_price)
                                <s class="ml-1 text-red-600 line-through">
                                    <span class="text-gray-500">US$ {{ number_format($tour->cost) }}</span>
                                </s>
                            @endif
                        </div>
                        <div>
                            <span class="text-gray-500">US$</span>
                            <span
                                class="ml-1 text-lg text-gray-500">{{ $tour->offer_price ? number_format($tour->offer_price) : number_format($tour->cost) }}
                            </span>
                            @if ($tour->offer_price)
                                <span class="ml-1 text-sm text-green-600">
                                    Save US$ {{ number_format($tour->cost - $tour->offer_price) }}
                                </span>
                            @endif
                        </div>
                        @if ($tour->people_price_range)
                            <div class="group">
                                <button class="inline-flex gap-1 text-sm text-gray-400 cursor-pointer">
                                    <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path
                                            d="M6.5 13L7.28446 14.5689C7.54995 15.0999 7.68269 15.3654 7.86003 15.5954C8.01739 15.7996 8.20041 15.9826 8.40455 16.14C8.63462 16.3173 8.9001 16.4501 9.43108 16.7155L11 17.5L9.43108 18.2845C8.9001 18.5499 8.63462 18.6827 8.40455 18.86C8.20041 19.0174 8.01739 19.2004 7.86003 19.4046C7.68269 19.6346 7.54995 19.9001 7.28446 20.4311L6.5 22L5.71554 20.4311C5.45005 19.9001 5.31731 19.6346 5.13997 19.4046C4.98261 19.2004 4.79959 19.0174 4.59545 18.86C4.36538 18.6827 4.0999 18.5499 3.56892 18.2845L2 17.5L3.56892 16.7155C4.0999 16.4501 4.36538 16.3173 4.59545 16.14C4.79959 15.9826 4.98261 15.7996 5.13997 15.5954C5.31731 15.3654 5.45005 15.0999 5.71554 14.5689L6.5 13Z"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M15 2L16.1786 5.06442C16.4606 5.79765 16.6016 6.16426 16.8209 6.47264C17.0153 6.74595 17.254 6.98475 17.5274 7.17909C17.8357 7.39836 18.2024 7.53937 18.9356 7.82138L22 9L18.9356 10.1786C18.2024 10.4606 17.8357 10.6016 17.5274 10.8209C17.254 11.0153 17.0153 11.254 16.8209 11.5274C16.6016 11.8357 16.4606 12.2024 16.1786 12.9356L15 16L13.8214 12.9356C13.5394 12.2024 13.3984 11.8357 13.1791 11.5274C12.9847 11.254 12.746 11.0153 12.4726 10.8209C12.1643 10.6016 11.7976 10.4606 11.0644 10.1786L8 9L11.0644 7.82138C11.7976 7.53937 12.1643 7.39836 12.4726 7.17909C12.746 6.98475 12.9847 6.74595 13.1791 6.47264C13.3984 6.16426 13.5394 5.79765 13.8214 5.06442L15 2Z"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    More discounts in group
                                </button>

                                <div
                                    class="absolute left-0 z-10 w-64 p-2 transition bg-blue-100 border border-primary/20 rounded-sm shadow-sm opacity-0 pointer-events-none group-hover:-translate-y-2 translate-2 bottom-full group-hover:opacity-100 group-focus-within:opacity-100">
                                    <table class="w-full">
                                        <thead>
                                            <th
                                                class="px-1 py-2 text-left border-b border-blue-300 text-primary font-display">
                                                No of people</th>
                                            <th
                                                class="px-1 py-2 text-right border-b border-blue-300 text-primary font-display">
                                                Price per person</th>
                                        </thead>
                                        <tbody>
                                            @forelse ($tour->people_price_range as $item)
                                                <tr>
                                                    <td
                                                        class="px-1 py-2 text-sm border-blue-200 @if (!$loop->last) border-b @endif">
                                                        {{ $item['from'] }}
                                                        {{ $item['to'] != '' ? ' - ' . $item['to'] : '' }}</td>
                                                    <td
                                                        class="px-1 py-2 text-sm text-right border-blue-200 @if (!$loop->last) border-b @endif">
                                                        ${{ number_format($item['price']) }}</td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                <a href="{{ route('front.trips.show', $tour) }}"
                    class="inline-flex items-center gap-1 px-4 py-2 text-sm tracking-wide uppercase border-2 rounded-lg border-primary/20 text-primary hover:bg-light hover:border-primary">
                    Explore
                    <svg class="w-4 h-4">
                        <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#arrownarrowright" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
