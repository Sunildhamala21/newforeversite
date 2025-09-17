<div class="flex flex-col overflow-hidden bg-gray-100 border border-gray-200 rounded-lg sm:flex-row not-prose">
    <div class="flex flex-col flex-grow p-4 lg:p-6">

        <div class="flex flex-wrap items-center justify-between gap-2 sm:flex-nowrap">
            <div class="text-2xl font-display">{{ $trip->name }} | {{ $trip->duration }} days</div>

            @if ($trip->reviews_count > 0)
                <div class="flex items-center justify-center gap-2 whitespace-nowrap">
                    <div class="flex items-center gap-0.2 text-accent">
                        <svg class="size-5">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#star" />
                        </svg>
                        {{ number_format($trip->trip_reviews_avg_rating, 1) }}
                    </div>
                    <span class="text-xs">({{ $trip->trip_reviews_count }} reviews)</span>
                </div>
            @endif
        </div>
        <div class="flex items-center justify-between gap-4 mt-2">
            <span class="inline-block px-3 py-1 text-xs bg-white border border-gray-200 rounded">
                {{ $trip->trip_activity_type }}
            </span>
        </div>

        <div class="flex flex-wrap items-end justify-between flex-grow mt-4">
            <div>
                @if ($trip->cost)
                    <div class="relative price">
                        <div class="mr-2 text-gray-500">
                            <span class="text-sm">From</span>
                            @if ($trip->offer_price)
                                <s class="ml-1 text-red-600">
                                    US$ {{ number_format($trip->cost) }}
                                </s>
                            @endif
                        </div>
                        <div>
                            <span class="text-gray-500">US$</span>
                            <span class="ml-1 text-lg text-gray-500">{{ $trip->offer_price ? number_format($trip->offer_price) : number_format($trip->cost) }} </span>
                            @if ($trip->offer_price)
                                <span class="ml-1 text-sm text-green-600">
                                    Save US$ {{ number_format($trip->cost - $trip->offer_price) }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            <a href="{{ route('front.trips.show', $trip) }}" class="inline-flex items-center gap-2 px-3 py-2 mt-4 text-sm font-semibold rounded-lg whitespace-nowrap bg-accent">View Trip
                <svg class="size-6"
                     viewBox="0 0 24 24"
                     fill="currentColor"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.99974 12.9999L1.9996 11L15.5858 11V5.58582L22 12L15.5858 18.4142V13L1.99974 12.9999Z"></path>
                </svg>
            </a>
        </div>
    </div>

    <div class="p-2">
        <img src="{{ $trip->mediumImageUrl }}"
             alt=""
             class="object-cover w-full aspect-[3/2] rounded-lg sm:w-64">
    </div>
</div>
