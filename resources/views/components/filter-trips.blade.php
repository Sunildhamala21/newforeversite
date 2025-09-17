<div class="bg-primary/10">
    <div class="container flex flex-col gap-10 lg:flex-row items" x-data="{ filters: {{ Js::from($filters) }}, filteredTrips: false, showFiltersOnMobile: false }" x-init="$watch('filters', value => {
        let url = '{{ route('front.trips.index') }}';
        axios.get(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            params: {
                keyword: value.keyword,
                activities: value.activities?.length ? value.activities.join(',') : [],
                destinations: value.destinations?.length ? value.destinations.join(',') : [],
                regions: {{ $filters['regions'] ? "'" . $filters['regions'][0] . "'" : '[]' }},
                difficulties: value.difficulties?.length ? value.difficulties.join(',') : [],
                seasons: value.seasons?.length ? value.seasosn.join(',') : [],
                duration: (value.minDuration || value.maxDuration) ? `${value.minDuration ?? ''}-${value.maxDuration ?? ''}` : [],
                price: (value.minPrice || value.maxPrice) ? `${value.minPrice ?? ''}-${value.maxPrice ?? ''}` : [],
            },
        }).then(res => {
            filteredTrips = res.data;
            @if(request()->routeIs('front.trips.index'))
            window.history.pushState({ path: url }, '', res.request.responseURL);
            @endif
        })
    })">
        <div
            class="flex-shrink-0 pt-10 lg:pt-20 lg:pb-20 w-80 max-h-[calc(100vh-125px)] overflow-y-auto items-stretch lg:sticky top-4">
            <div class="text-sm">Showing <span
                    x-text="filteredTrips ? filteredTrips.length : {{ $trips->count() }}">{{ $trips->count() }}</span>
                trips</div>
            <div class="relative mt-2">
                <input type="text" id="keyword" class="w-full p-3 pl-10 border-gray-300 rounded-md"
                    value="{{ $get_keyword ?? '' }}" x-model.debounce="filters.keyword" placeholder="Search Trips"
                    name="keyword" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="absolute -translate-y-1/2 left-3 top-1/2 size-4" viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </div>
            <div class="mt-4">
                <div class="hidden text-sm lg:block">Filter by</div>
                <button class="inline-flex gap-2 px-2 py-1 text-sm text-white rounded bg-primary lg:hidden"
                    x-on:click="showFiltersOnMobile=!showFiltersOnMobile">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="size-5">
                        <rect width="256" height="256" fill="none" />
                        <path
                            d="M34.1,61.38A8,8,0,0,1,40,48H216a8,8,0,0,1,5.92,13.38L152,136v58.65a8,8,0,0,1-3.56,6.66l-32,21.33A8,8,0,0,1,104,216V136Z"
                            fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="16" />
                    </svg>
                    Filter by
                </button>
            </div>
            <div class="mt-4 space-y-2 max-lg:not-[.active]:hidden lg:block"
                x-bind:class="{ 'active': showFiltersOnMobile }">
                <x-collapse class="relative px-5 bg-white" x-data="{ open: false }">
                    <x-slot:trigger
                        class="relative flex items-center justify-between w-full py-3 text-left bg-white"
                        x-on:click="open=!open">
                        <div>
                            <div class="font-semibold uppercase">Activity</div>
                            <div class="text-sm capitalize"
                                x-text="filters.activities?.length ? filters.activities.join(', ').replaceAll('-', ' '): 'Any activity'">
                            </div>
                        </div>
                    </x-slot>
                    <x-slot:target>
                        <div class="pt-2 pb-4 border-t border-gray-300">
                            @foreach ($activities as $activity)
                                <label class="flex items-center gap-3 px-2 py-1">
                                    <input type="checkbox" class="rounded size-4" value="{{ $activity->slug }}"
                                        x-model="filters.activities">
                                    <span class="text-sm">{{ $activity->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </x-slot>
                </x-collapse>
                <x-collapse class="relative px-5 bg-white" x-data="{ open: false }">
                    <x-slot:trigger
                        class="relative flex items-center justify-between w-full py-3 text-left bg-white"
                        x-on:click="open=!open">
                        <div>
                            <div class="font-semibold uppercase">Destination</div>
                            <div class="text-sm capitalize"
                                x-text="filters.destinations?.length ? filters.destinations.join(', ').replaceAll('-', ' '): 'Anywhere'">
                            </div>
                        </div>
                    </x-slot>
                    <x-slot:target>
                        <div class="pt-2 pb-4 border-t border-gray-300">
                            @foreach ($destinations as $destination)
                                <label class="flex items-center gap-3 px-2 py-1">
                                    <input type="checkbox" class="rounded size-4" value="{{ $destination->slug }}"
                                        x-model="filters.destinations">
                                    <span class="text-sm">{{ $destination->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </x-slot>
                </x-collapse>
                <x-collapse class="relative px-5 bg-white" x-data="{ open: false }">
                    <x-slot:trigger
                        class="relative flex items-center justify-between w-full py-3 text-left bg-white"
                        x-on:click="open=!open">
                        <div>
                            <div class="font-semibold uppercase">Duration</div>
                            <div class="text-sm"
                                x-text="filters.minDuration || filters.maxDuration ? `${filters.minDuration || 'min'}-${filters.maxDuration || 'max'} days`  : 'Any duration'">
                            </div>
                        </div>
                    </x-slot>
                    
                    <x-slot:target>
                        <div class="pt-2 pb-4 border-t border-gray-300">
                            <div class="grid grid-cols-2 gap-3">
                            @php
                                $min = is_numeric($minDurationAllTrips) ? (int) $minDurationAllTrips : 1;
                                $max = is_numeric($maxDurationAllTrips) ? (int) $maxDurationAllTrips : 30;
                            @endphp

                                <div>
                                    <label class="text-xs">Minimum</label>
                                    <select name="" id=""
                                        class="w-full text-sm border border-gray-300 rounded-md"
                                        x-model="filters.minDuration">
                                        <option value="">Minimum</option>
                                        @foreach (range($min, $max) as $i)
                                            <option>{{ $i }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs">Maximum</label>
                                    <select name="" id=""
                                        class="w-full text-sm border border-gray-300 rounded-md"
                                        x-model="filters.maxDuration">
                                        <option value="">Maximum</option>
                                        @foreach (range($min, $max) as $i)
                                            <option>{{ $i }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </x-collapse>
                <x-collapse class="relative px-5 bg-white" x-data="{ open: false }">
                    <x-slot:trigger
                        class="relative flex items-center justify-between w-full py-3 text-left bg-white"
                        x-on:click="open=!open">
                        <div>
                            <div class="font-semibold uppercase">Difficulty</div>
                            <div class="text-sm capitalize"
                                x-text="filters.difficulties.length ? filters.difficulties.join(', '): 'Any Difficulty'">
                            </div>
                        </div>
                    </x-slot>
                    <x-slot:target>
                        <div class="pt-2 pb-4 border-t border-gray-300">
                            @foreach (\App\Enums\Difficulty::cases() as $case)
                                <label class="flex items-center gap-3 px-2 py-1">
                                    <input type="checkbox" class="rounded size-5"
                                        value="{{ str($case->name)->slug() }}" x-model="filters.difficulties">
                                    <span class="text-sm">{{ $case->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </x-slot>
                </x-collapse>
                <x-collapse class="relative px-5 bg-white" x-data="{ open: false }">
                    <x-slot:trigger
                        class="relative flex items-center justify-between w-full py-3 text-left bg-white"
                        x-on:click="open=!open">
                        <div>
                            <div class="font-semibold uppercase">Price</div>
                            <div class="text-sm"
                                x-text="filters.minPrice || filters.maxPrice ? `US$ ${filters.minPrice || 'min'} - US$${filters.maxPrice || 'max'}`  : 'Any price'">
                            </div>
                        </div>
                    </x-slot>
                    <x-slot:target>
                        <div class="pt-2 pb-4 border-t border-gray-300">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs">Minimum</label>
                                    <select name="" id=""
                                        class="w-full text-sm border border-gray-300 rounded-md"
                                        x-model="filters.minPrice">
                                        <option value="">Minimum</option>
                                        @foreach (range(0, 5000, 500) as $i)
                                            <option>{{ $i }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs">Maximum</label>
                                    <select name="" id=""
                                        class="w-full text-sm border border-gray-300 rounded-md"
                                        x-model="filters.maxPrice">
                                        <option value="">Maximum</option>
                                        @foreach (range(0, 5000, 500) as $i)
                                            <option>{{ $i }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </x-collapse>
            </div>
        </div>

        <div class="flex-grow lg:pt-20 lg:pb-20">

            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3" x-show="!filteredTrips" x-cloak>
                @foreach ($trips as $trip)
                    <x-trip-card-simple :trip="$trip" />
                @endforeach
            </div>

            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3" x-show="filteredTrips && filteredTrips.length>0"
                x-cloak>
                <template x-for="trip in filteredTrips" x-bind:key="trip.slug">
                    <div class="flex flex-col bg-white shadow-md tour">
                        <div class="relative">
                            <a href="trip.link">
                                <img x-bind:src="trip.imageUrl" x-bind:alt="trip.name" width="480"
                                    height="360" loading="lazy" class="object-cover w-full rounded-t-xl">
                            </a>
                            <div
                                class="absolute bottom-0 translate-y-1/2 right-2 bg-white px-1 py-0.5 rounded-full border-2 border-primary/20">
                                <div x-show="trip.reviews_count > 0" class="flex items-center justify-center gap-2">
                                    <div class="flex items-center gap-1 font-semibold text-accent">
                                        <svg class="size-5">
                                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#star" />
                                        </svg>
                                        <span x-text="trip.avg_rating"></span>
                                    </div>
                                    <span class="text-xs" x-text="`(${trip.reviews_count})`"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between bottom flex-grow-1">
                            <div class="flex flex-col px-4 pt-8 pb-4 flex-grow-1">
                                {{-- Trip Name --}}
                                <a x-bind:href="trip.link" class="mb-4 flex-grow-1">
                                    <div>
                                        <span class="mb-2 text-xl text-gray-600 font-display"
                                            x-text="trip.name"></span>
                                        <span class="whitespace-nowrap"
                                            x-text="`- ${trip.duration} ` + (trip.duration > 1 ? 'days' : 'day')"></span>
                                    </div>
                                </a>

                                {{-- Action Buttons --}}
                                <div class="flex items-end justify-between">

                                    {{-- Price --}}
                                    <div class="relative price">
                                        <div x-show="trip.cost">
                                            <div class="mr-2 text-gray-500">
                                                <span class="text-sm">From</span>
                                                <s class="ml-1 text-red-600 line-through" x-show="trip.offer_price">
                                                    <span class="text-gray-500"
                                                        x-text="trip.cost?.toLocaleString()"></span>
                                                </s>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">US$</span>
                                                <span class="ml-1 text-lg font-semibold text-gray-500"
                                                    x-text="trip.offer_price ? trip.offer_price?.toLocaleString() : trip.cost?.toLocaleString()">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <a x-bind:href="trip.link"
                                        class="inline-flex items-center gap-1 px-3 py-1 text-sm tracking-wide uppercase border-2 rounded-lg border-primary/20 text-primary hover:bg-light hover:border-primary">
                                        Explore
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
