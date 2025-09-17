@props(['trip'])
<div class="flex flex-col bg-white shadow-md tour">
    <div class="relative">
        <a href="{{ route('front.trips.show', $trip) }}">
            <img src="{{ $trip->mediumImageUrl }}" alt="{{ $trip->name }}" width="480" height="360" loading="lazy"
                class="object-cover rounded-t-xl w-full">
        </a>
        <div
            class="absolute bottom-0 translate-y-1/2 right-2 bg-white px-1 py-0.5 rounded-full border-2 border-primary/20">
            @if ($trip->trip_reviews->count() > 0)
                <div class="flex items-center justify-center gap-2">
                    <div class="flex items-center gap-1 text-accent font-semibold">
                        <svg class="size-5">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#star" />
                        </svg>
                        {{ number_format($trip->trip_reviews->avg('rating'), 1) }}
                    </div>
                    <span class="text-xs">({{ $trip->trip_reviews->count() }})</span>
                </div>
            @endif
        </div>
    </div>
    <div class="flex flex-col justify-between bottom flex-grow-1">
        <div class="flex flex-col px-4 flex-grow-1 pt-8 pb-4">
            {{-- Trip Name --}}
            <a href="{{ route('front.trips.show', $trip) }}" class="mb-4 flex-grow-1">
                <div>
                    <span class="mb-2 text-xl text-gray-600 font-display">{{ $trip->name }}</span>
                    <span class="whitespace-nowrap"> - {{ $trip->duration }}
                        {{ $trip->duration > 1 ? 'days' : 'day' }}</span>
                </div>
            </a>

            {{-- Action Buttons --}}
            <div class="flex items-end justify-between">

                {{-- Price --}}
                <div class="relative price">
                    @if ($trip->cost)
                        <div class="mr-2 text-gray-500">
                            <span class="text-sm">From</span>
                            @if ($trip->offer_price)
                                <s class="ml-1 text-red-600 line-through">
                                    <span class="text-gray-500">US$ {{ number_format($trip->cost) }}</span>
                                </s>
                            @endif
                        </div>
                        <div>
                            <span class="text-gray-500">US$</span>
                            <span
                                class="ml-1 text-lg text-gray-500 font-semibold">{{ $trip->offer_price ? number_format($trip->offer_price) : number_format($trip->cost) }}
                            </span>
                        </div>
                    @endif
                </div>
                <a href="{{ route('front.trips.show', $trip) }}"
                    class="inline-flex items-center gap-1 px-3 py-1 text-sm tracking-wide uppercase border-2 rounded-lg border-primary/20 text-primary hover:bg-light hover:border-primary">
                    Explore
                </a>
            </div>
        </div>
    </div>
</div>
