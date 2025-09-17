<div class="w-full translate-y-1/2 lg:bottom-48">
    <div class="max-w-5xl px-4 mx-auto" x-model="keyword" x-on:click.outside="reset()" x-on:keyup.esc="reset()"
        x-on:keyup.down="selectNext()" x-on:keyup.up="selectPrev()" x-init="$watch('keyword', () => selectedIndex = '')">
        @php
            $allTrips = Cache::remember('trip_list', 300, function () {
                return \App\Models\Trip::where('status', 1)->get(['id', 'name', 'slug', 'offer_price', 'duration']);
            });
            $trips = [];
            foreach ($allTrips as $index => $trip) {
                $trips[$index]['name'] = $trip->name;
                $trips[$index]['duration'] = $trip->duration;
                $trips[$index]['image_url'] = asset($trip->thumbImageUrl);
                $trips[$index]['offer_price'] = $trip->offer_price;
                $trips[$index]['url'] = route('front.trips.show', $trip);
            }
            $formattedTrips = json_encode($trips);
        @endphp
        <span id="tripsJson" class="hidden" x-init="$store.tripStore.trips">{!! $formattedTrips !!}</span>
        <div class="relative max-w-xl mx-auto">
            <form action="{{ route('front.trips.index') }}" x-on:submit.prevent="handleSubmit($event.target)">
                <input type="search" name="keyword"
                    class="w-full px-4 py-4 text-lg text-gray-600 border-2 border-white rounded-lg shadow-sm focus:ring-0 focus:border-accent focus:outline-0"
                    placeholder="Search Trips" x-ref="headerSearchInput">
                <button
                    class="absolute flex flex-col p-2 -translate-y-1/2 rounded-lg bg-light text-primary right-2 top-1/2 focus:bg-primary focus:text-white hover:bg-primary hover:text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                    </svg>
                </button>
            </form>
            <div class="absolute w-full overflow-scroll rounded-lg max-h-96 top-[calc(100%+1rem)] border border-gray-200 shadow-lg"
                x-show="filteredTrips.length > 0" x-transition:enter="transition duration-500"
                x-transition:enter-start="translate-y-4">
                <ul x-ref="results">
                    <template x-for="(trip, index) in filteredTrips" :key="trip.url">
                        <li
                            :class="{
                                'transition': true,
                                'bg-gray-100 hover:bg-gray-50': selectedIndex !== index,
                                'bg-light': selectedIndex === index,
                                'border-b border-gray-200': index !== filteredTrips.length
                            }">
                            <a x-bind:href="trip.url" class="block px-4 py-2">
                                <div class="flex gap-4">
                                    <img :src="trip.image_url" alt=""
                                        class="object-cover w-16 h-16 rounded-lg">
                                    <div class="grow">
                                        <div class="text-lg" x-text="trip.name"></div>
                                        <div class="flex justify-between gap-2">
                                            <span class="text-sm text-gray-600" x-text="`${trip.duration} days`"></span>
                                            <span class="text-sm text-gray-600" x-show="trip.offer_price"
                                                x-text="`US $ ${trip.offer_price}`"></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</div>
