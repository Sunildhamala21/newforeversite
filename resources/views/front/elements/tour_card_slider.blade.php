<div class="relative">
    <div class="grid gap-10 lg:grid-cols-2">
        <div>
            <img src="{{ $tour->imageUrl }}" alt="{{ $tour->name }}" style="border-radius: 10px;" loading="lazy">
        </div>
        <div>
            <h3 class="mb-10 text-3xl uppercase font-display">
                {{ $tour->name }}
            </h3>
            <div class="mb-6 prose text-white/80">
                <p> {!! truncate(trim(strip_tags($tour->trip_info['overview'] ?? '')), 300) !!} </p>
            </div>

            <div class="flex flex-wrap gap-6 mb-4">
                <div class="flex items-center gap-4 p-2 rounded-sm bg-primary-dark">
                    <svg class="w-6 h-6">
                        <use xlink:href="{{ asset('assets/front/img/sprite.svg#calendar') }}"></use>
                    </svg>
                    <div>
                        <div class="text-sm font-bold uppercase">Duration</div>
                        <span class="fs-lg bold"> <?= $tour->duration ?> </span> days
                    </div>
                </div>
                <div class="flex items-center gap-4 p-2 rounded-sm bg-primary-dark">
                    <svg class="w-6 h-6">
                        <use xlink:href="{{ asset('assets/front/img/sprite.svg#emojihappy') }}"></use>
                    </svg>
                    <div>
                        <div class="text-sm font-bold uppercase">Difficulty</div>
                        {{ $tour->difficulty_grade_value }}
                    </div>
                </div>
                @if ($tour->cost)
                    <div class="mb-4 price">
                        <div>
                            <span class="text-sm">
                                from
                            </span>
                            <s class="text-red-400">
                                USD {{ number_format($tour->cost) }}
                            </s>
                        </div>
                        <div class="font-display">
                            <span>USD</span>
                            <span class="text-3xl">{{ number_format($tour->offer_price) }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <div>
                <a href="{{ route('front.trips.show', $tour) }}"
                    class="inline-flex gap-2 px-4 py-4 tracking-wide text-white no-underline uppercase bg-green-600 rounded-lg font-display hover:bg-green-700">
                    Explore
                    <svg class="w-6 h-6">
                        <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowright') }}"></use>
                    </svg>
                </a>
                {{-- <a href="tour-details.php" class="btn btn-gray">
                    Book Now
                </a> --}}
            </div>
        </div>
    </div>
</div>
