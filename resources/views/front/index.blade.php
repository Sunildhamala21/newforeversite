@extends('layouts.front')
@section('content')
    <!-- Slider -->
    {{-- @include('front.elements.banner2') --}}

    <h1 class="sr-only">{{ config('app.name') }} - Home</h1>

    <section>
        <div class="relative overflow-hidden bg-dark/30">
            <img src="{{ asset('assets/front/img/mountains.webp') }}"
                class="absolute inset-0 object-cover w-full h-full lazyload -z-1" alt="" width="1600" height="1000">
            <div class="flex flex-col w-full gap-10 pt-20 text-white">
                <div class="container flex flex-col items-center justify-center flex-grow text-center">
                    <div class="text-3xl font-display uppercase sm:text-5xl">
                    Adventure Awaits with Himalayan Friends Trekking
                    </div>
                    <div class="prose text-white mt-4">
                        <p>Explore thrilling trails, hidden valleys, and tranquil escapes. Whatever your pace, we help you design a personalized adventure through the majestic Himalayas.</p>
                    </div>
                </div>
                <div x-data="{ activeTab: 'activities' }" class="pb-10 bg-gradient-to-t from-black/50 from-90% to-black/0">
                    <div class="container space-x-6">
                        <button x-on:click="activeTab='activities'">
                            <span class="relative">
                                Activities
                                <span class="absolute bottom-0 left-0 right-0 w-full h-1 translate-y-2 bg-accent"
                                    x-show="activeTab=='activities'"></span>
                            </span>
                        </button>
                        <button x-on:click="activeTab='destinations'">
                            <span class="relative">
                                Destinations
                                <span class="absolute bottom-0 left-0 right-0 w-full h-1 translate-y-2 bg-accent"
                                    x-show="activeTab=='destinations'"></span>
                            </span>
                        </button>
                        <button x-on:click="activeTab='regions'">
                            <span class="relative">
                                Regions
                                <span class="absolute bottom-0 left-0 right-0 w-full h-1 translate-y-2 bg-accent"
                                    x-show="activeTab=='regions'"></span>
                            </span>
                        </button>
                    </div>
                    <div x-show="activeTab==='activities'" class="mt-10">
                        <x-slider>
                            @foreach ($activities as $activity)
                                <x-activity-card :activity="$activity" :link="route('front.activities.show', $activity)" />
                            @endforeach
                        </x-slider>
                    </div>
                    <div x-show="activeTab==='destinations'" class="mt-10">
                        <x-slider>
                            @foreach ($destinations as $destination)
                                <x-activity-card :activity="$destination" :link="route('front.destinations.show', $destination)" />
                            @endforeach
                        </x-slider>
                    </div>
                    <div x-show="activeTab==='regions'" class="mt-10" x-cloak>
                        <x-slider>
                            @foreach ($regions as $region)
                                <x-activity-card :activity="$region" :link="route('front.regions.show', $region)" />
                            @endforeach
                        </x-slider>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    
    <!-- About-->
    <div class="py-10 lg:py-20">
        <div class="container grid md:grid-cols-2 gap-10 px-4 mx-auto">
            <div>
                <p class="mb-2 text-xl font-handwriting text-primary">About Us</p>
                <div class="flex mb-8">
                    <h2 class="relative pr-10 text-2xl font-bold text-center  uppercase lg:text-3xl font-display">
                        {{ Setting::get('homePage')['welcome']['title'] ?? '' }}
                        <div class="absolute right-0 w-6 h-1 rounded-sm top-1/2 bg-accent"></div>
                    </h2>
                </div>
                <div class="mx-auto prose">{!! Setting::get('homePage')['welcome']['content'] ?? '' !!}</div>
            </div>

            {{-- Why Travel with us --}}
            <div class="grid gap-8 bg-primary text-white p-10">
                <div class="flex">
                    <h2 class="relative pr-10 text-2xl font-bold uppercase lg:text-3xl font-display">
                        Why travel with us
                        <div class="absolute right-0 w-6 h-1 rounded top-1/2 bg-accent"></div>
                    </h2>
                </div>
                <div class="grid gap-4 mb-4">
                    <div>
                        <div class="flex gap-4 mb-2">
                            <img src="{{ asset('assets/front/img/experience.webp') }}"
                                class="flex-shrink-0 size-14 p-1 rounded-lg" alt="">
                            <div class="prose prose-invert">
                                <h2 class="font-semibold text-base mb-1">years of experience</h2>
                                <p>Decades of Himalayan trekking expertise ensure your journey is safe, insightful, and authentic.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex gap-4 mb-2">
                            <img src="{{ asset('assets/front/img/tailor-made.webp') }}"
                                class="flex-shrink-0 size-14 p-1 rounded-lg" alt="">
                            <div class="prose prose-invert">
                                <h2 class="font-semibold text-base mb-1">Tailored trips</h2>
                                <p>Every trek is customized to match your pace, preferences, and experience level.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex gap-4 mb-2">
                            <img src="{{ asset('assets/front/img/best-price.webp') }}"
                                class="flex-shrink-0 size-14 p-1 rounded-lg" alt="">
                            <div class="prose prose-invert">
                                <h2 class="font-semibold text-base mb-1">Best price guaranteed</h2>
                                <p>Affordable adventures without compromising on safety or quality.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex gap-4 mb-2">
                            <img src="{{ asset('assets/front/img/support.webp') }}"
                                class="flex-shrink-0 size-14 p-1 rounded-lg" alt="">
                            <div class="prose prose-invert">
                                <h2 class="font-semibold text-base mb-1">24/7 support</h2>
                                <p>Reliable assistance before, during, and after your trek—whenever you need it.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular right now -->
    <div class="py-10 lg:py-20 featured bg-primary/20">
        <div class="container">
            <div class="flex justify-center">
                <div>
                    <p class="mb-2 text-2xl text-center text-primary font-handwriting">The best of what we offer</p>
                    <h2
                        class="relative px-10 mb-8 text-2xl font-bold text-center text-gray-600 uppercase lg:text-4xl font-display">
                        {{ Setting::get('homePage')['trip_block_2']['title'] ?? '' }}
                        <div class="absolute left-0 w-6 h-1 rounded-sm top-1/2 bg-accent"></div>
                        <div class="absolute right-0 w-6 h-1 rounded-sm top-1/2 bg-accent"></div>
                    </h2>
                </div>
            </div>

            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($block_2_trips as $block_2_tour)
                    @include('front.elements.tour-card', ['tour' => $block_2_tour])
                @empty
                @endforelse
            </div>
        </div>
    </div> <!-- Popular right now -->

    {{-- Group Departures --}}
    <div class="py-20 text-white bg-primary" x-data="{ activeYear: {{ $tripDepartures->keys()->first() }} }">
        <div class="container max-w-5xl">
            <div class="flex flex-col items-start justify-between gap-2 md:flex-row">
                <div>
                    <h2 class="text-3xl font-medium font-display">Join a Group Trek</h2>
                    <div class="mt-4 prose text-white">
                        <p>With Himalayan Friends Trekking, group departures turn solo trips into shared stories. Walk beside new friends, laugh around campfires, and create memories that last beyond the mountains.</p>
                    </div>
                </div>
                <a href="{{ route('front.trips.index', ['mode' => 'departures']) }}"
                    class="px-6 py-1 mt-2 text-lg border rounded-lg border-accent whitespace-nowrap font-display">All
                    Upcoming Treks</a>
            </div>
            <div class="mt-10 space-x-3">
                @foreach ($tripDepartures as $year => $months)
                    <button
                        x-bind:class="{
                            'px-6 py-1 text-lg border rounded-lg border-accent': true,
                            'bg-accent text-dark': activeYear ===
                                {{ $year }}
                        }"
                        x-on:click="activeYear={{ $year }}">{{ $year }}</button>
                @endforeach
            </div>
            @foreach ($tripDepartures as $year => $months)
                <div x-show="activeYear === {{ $year }}" class="mt-10" x-data="{ activeMonth: '{{ $months->keys()->first() }}' }">
                    <div class="text-lg font-semibold text-center">{{ $year }} Availability</div>
                    <div class="mt-4 space-x-3 space-y-1">
                        @foreach ($months as $month => $departures)
                            <button
                                x-bind:class="{
                                    'px-6 py-1 text-lg border rounded-lg border-accent': true,
                                    'bg-accent text-dark': activeMonth ==
                                        '{{ $month }}'
                                }"
                                x-on:click="activeMonth='{{ $month }}'">{{ $month }}</button>
                        @endforeach
                    </div>
                    @foreach ($months as $month => $departures)
                        <div class="mt-6 space-y-4 overflow-scroll max-h-160"
                            x-show="activeMonth === '{{ $month }}'">
                            @foreach ($departures as $departure)
                                <div @class([
                                    'grid items-center grid-cols-2 p-4 bg-white gap-x-10 gap-y-2 md:grid-cols-6 text-gray-700 rounded-xl',
                                    'opacity-50' => $departure->seats == 0,
                                ])>
                                    <div class="col-span-2">
                                        <a href="{{ route('front.trips.show', $departure->trip) }}"
                                            class="text-lg font-semibold">{{ $departure->trip->name }}</a>
                                        <div class="mt-2 text-sm text-gray-500">Duration: {{ $departure->trip->duration }}
                                            days
                                        </div>
                                        <div class="mt-2 font-semibold">USD ${{ $departure->price }}</div>
                                        <div class="text-sm text-red-600 line-through"><span class="text-primary">USD
                                                ${{ $departure->trip->cost }}</span>
                                        </div>
                                    </div>
                                    <div class="relative grid grid-cols-2 col-span-2 gap-10">
                                        <div class="text-right">
                                            <div class="text-sm">{{ $departure->from_date->format('l') }}</div>
                                            <div class="font-semibold">
                                                {{ $departure->from_date->toFormattedDateString() }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm">{{ $departure->to_date->format('l') }}</div>
                                            <div class="font-semibold">{{ $departure->to_date->toFormattedDateString() }}
                                            </div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"
                                            class="absolute text-gray-400 left-1/2 top-1/2 -translate-1/2 size-6">
                                            <rect width="256" height="256" fill="none" />
                                            <circle cx="128" cy="128" r="96" fill="none"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="16" />
                                            <line x1="88" y1="128" x2="168" y2="128" fill="none"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="16" />
                                            <polyline points="136 96 168 128 136 160" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                        </svg>
                                    </div>
                                    <div @class(['text-red-600' => $departure->seats <= 3])>
                                        @if ($departure->seats > 0)
                                            <div class="text-sm">{{ $departure->seats }} left</div>
                                        @endif
                                        <div class="flex gap-1 font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="size-4">
                                                <rect width="256" height="256" fill="none" />
                                                <circle cx="128" cy="204" r="12" fill="currentColor" />
                                                <path d="M232,93.19a164,164,0,0,0-208,0" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="16" />
                                                <path d="M200,129a116,116,0,0,0-144,0" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="16" />
                                                <path d="M168,165a68,68,0,0,0-80,0" fill="none" stroke="currentColor"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                            </svg>
                                            {{ $departure->seats <= 3 ? ($departure->seats == 0 ? 'Sold Out' : 'Almost Sold') : 'Available' }}
                                        </div>
                                    </div>
                                    <div>
                                        @if ($departure->seats > 0)
                                            <a href="{{ route('front.trips.departure-booking', [$departure->trip, $departure]) }}"
                                                class="px-4 py-2 bg-primary text-white rounded text-sm">Book Now</a>
                                        @else
                                            <a href="" class="text-white bg-red-600 btn" disabled>Sold Out</a>
                                        @endif
                                    </div>
                                    {{-- <div class="col-span-2 font-serif text-xs text-center text-red-600 md:col-span-7">
                                        @if ($departure->seats > 0)
                                            Filling in fast
                                        @endif
                                    </div> --}}
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>


    <div class="py-10 bg-primary/20 lg:py-20">
        <div class="container">
            <div class="flex justify-center">
                <h2 class="relative px-10 text-2xl font-bold text-center text-gray-600 uppercase lg:text-4xl font-display">
                    Reviews
                    <div class="absolute left-0 w-6 h-1 rounded-sm top-1/2 bg-accent"></div>
                    <div class="absolute right-0 w-6 h-1 rounded-sm top-1/2 bg-accent"></div>
                </h2>
            </div>

            <!-- <x-tripadvisor-reviews-section /> -->

            {{-- reviews --}}
            <div class="mt-10">
                <p class="mb-6 text-lg text-center"><span
                        class="inline-block px-2 py-1 mr-2 font-semibold text-white bg-green-600 rounded-lg">{{ number_format($reviews->avg('rating'), 1) }}</span>
                    from
                    {{ $reviews->count() }}
                    reviews</p>
                <div class="grid gap-4 mb-10 lg:grid-cols-3">
                    @forelse ($reviews->take(3) as $review)
                        <div class="p-6 bg-white rounded-lg">
                            <div class="mb-4 prose prose-sm review">
                                <h3 class="mb-4 text-xl font-display">{{ $review->title }}</h3>
                                <p class="h-40 overflow-y-scroll pr-2">{{ $review->review }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    @if ($review->thumbImageUrl)
                                        <img src="{{ $review->thumbImageUrl }}" alt="{{ $review->review_name }}"
                                            loading="lazy">
                                    @else
                                        <div
                                            class="flex items-center justify-center w-16 h-16 text-xl rounded-full bg-primary/10 text-primary">
                                            {{ $review->review_name[0] }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold">{{ ucfirst($review->review_name) }}</div>
                                        <div class="text-sm text-gray">{{ $review->review_country }}</div>
                                        <div class="flex">
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg class="w-5 h-5 text-accent">
                                                    <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#star" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="text-center">
                    <a href="{{ route('front.reviews.index') }}" class="underline text-primary">
                        Read more reviews
                    </a>
                </div>
            </div>
        </div>
    </div>{{-- reviews --}}

    <!-- Trip of the month -->
    <div class="py-10 text-white lg:py-20 bg-primary">
        <div class="container">

            <p class="mb-2 text-2xl text-white font-handwriting">This doesn't get any better</p>

            <div class="flex flex-wrap justify-between gap-4 mb-8">
                <h2 class="relative pr-10 text-2xl font-bold uppercase lg:text-4xl font-display">
                    {{ Setting::get('homePage')['trip_block_3']['title'] ?? '' }}
                    <div class="absolute right-0 w-6 h-1 rounded-sm top-1/2 bg-accent"></div>
                </h2>
                <div class="flex justify-end gap-4 trips-month-slider-controls">
                    <button class="p-2 rounded-lg bg-primary-dark" aria-label="Previous">
                        <svg class="w-6 h-6 text-accent">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowleft') }}" />
                        </svg>
                    </button>
                    <button class="p-2 rounded-lg bg-primary-dark" aria-label="Next">
                        <svg class="w-6 h-6 text-accent">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowright') }}" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="trips-month-slider">
                @forelse ($block_3_trips as $block3tour)
                    @include('front.elements.tour_card_slider', ['tour' => $block3tour])
                @empty
                @endforelse
            </div>
        </div>
    </div>

    {{-- Plan your trip --}}
    @include('front.elements.plan_trip')

    {{-- Blog --}}
    <div class="py-10 bg-primary/20 lg:py-20 blog">
        <div class="container">

            <div class="flex justify-center">
                <h2
                    class="relative px-10 mb-16 text-2xl font-bold text-center text-gray-600 uppercase lg:text-4xl font-display">
                    Latest travel blog
                    <div class="absolute left-0 w-6 h-1 rounded-sm top-1/2 bg-accent"></div>
                    <div class="absolute right-0 w-6 h-1 rounded-sm top-1/2 bg-accent"></div>
                </h2>
            </div>

            <div class="grid gap-10 mb-6 lg:grid-cols-3">
                @forelse ($blogs as $blog)
                    @include('front.elements.blog_card')
                @empty
                @endforelse
            </div>
            <div class="text-center">
                <a href="{{ route('front.blogs.index') }}" class="text-sm btn btn-primary">Go to blog
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/home.js')
@endpush
