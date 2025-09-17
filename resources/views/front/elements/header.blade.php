<div class="py-2 bg-secondary text-white">
    <div class="container text-sm text-center space-x-2">
        <span class="animate-pulse">
            <span class="text-accent">★★</span> Join us for an unforgettable <a
                href="https://www.hftreks.com/trips/everest-base-camp-trek" class="underline">15-day Everest
                Base Camp Trek</a>, starting on <a
                href="https://www.hftreks.com/trips/everest-base-camp-trek/departure-booking/4"
                class="underline">November 1st</a>! <span class="text-accent">★★</span>
        </span>
        @if (!request()->routeIs('front.trip-departures.index'))
            <a href="{{ route('front.trip-departures.index') }}"
                class="hidden px-3 py-1 uppercase rounded-full lg:inline-flex bg-accent font-display">Join Group</a>
        @endif
    </div>
</div>
<header class="w-full transition header" x-data="{ mobilenavOpen: false }">
    <div class="container relative flex items-center justify-between w-full py-2 gap-4">
        <a class="shrink-0" href="{{ route('home') }}">
            <img src="{{ asset('assets/front/img/logo.webp') }}" class="block w-auto h-16"
                alt="{{ config('app.name') }}" width="360" height="122">
        </a>

        {{-- Talk to expert --}}
        <div class="flex items-center lg:gap-6 gap-2">
            <div class="flex items-center gap-2 sm:block hidden">
                <div class="text-right md:block hidden">
                    <div class="text-xs">Travelers' Choice</div>
                    <div class="font-semibold text-sm">Awards 2025</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 713.496 713.496" class="h-10 flex-shrink-0"
                    fill="currentColor">
                    <circle fill="#38DE9F" cx="356.749" cy="356.748" r="356.748"></circle>
                    <path class="text-dark" fill="currentColor"
                        d="M577.095,287.152l43.049-46.836h-95.465c-47.792-32.646-105.51-51.659-167.931-51.659 c-62.342,0-119.899,19.054-167.612,51.659H93.432l43.049,46.836c-26.387,24.075-42.929,58.754-42.929,97.259 c0,72.665,58.914,131.578,131.579,131.578c34.519,0,65.968-13.313,89.446-35.077l42.172,45.919l42.172-45.879 c23.478,21.764,54.887,35.037,89.406,35.037c72.665,0,131.658-58.913,131.658-131.578 C620.024,345.866,603.483,311.188,577.095,287.152z M225.17,473.458c-49.188,0-89.047-39.859-89.047-89.047 s39.86-89.048,89.047-89.048c49.187,0,89.047,39.86,89.047,89.048S274.357,473.458,225.17,473.458z M356.788,381.82 c0-58.595-42.61-108.898-98.853-130.383c30.413-12.716,63.776-19.771,98.813-19.771s68.439,7.055,98.853,19.771 C399.399,272.962,356.788,323.226,356.788,381.82z M488.367,473.458c-49.188,0-89.048-39.859-89.048-89.047 s39.86-89.048,89.048-89.048s89.047,39.86,89.047,89.048S537.554,473.458,488.367,473.458z M488.367,337.694 c-25.79,0-46.677,20.887-46.677,46.677c0,25.789,20.887,46.676,46.677,46.676c25.789,0,46.676-20.887,46.676-46.676 C535.042,358.621,514.156,337.694,488.367,337.694z M271.846,384.411c0,25.789-20.887,46.676-46.676,46.676 s-46.676-20.887-46.676-46.676c0-25.79,20.887-46.677,46.676-46.677C250.959,337.694,271.846,358.621,271.846,384.411z">
                    </path>
                </svg>
            </div>
            <div class="hidden sm:flex items-center sm:gap-2 gap-1">
                <div class="relative shrink-0">
                    <img src="{{ asset('assets/front/img/owner.webp') }}" alt="{{ config('app.name') }}"
                        class="w-12 h-12 border-2 rounded-full border-accent object-cover">
                    <div class="absolute w-3 h-3 rounded-full bottom-px right-px bg-secondary"></div>
                </div>
                <div class="hidden md:block">
                    <div class="flex items-center gap-1">
                        <span class="text-xs text-gray-500">Quick Inquiry</span>
                    </div>
                    <div>
                        <a href="https://api.whatsapp.com/send/?phone={{ Setting::get('mobile1') ? preg_replace('/[^0-9]/', '', Setting::get('mobile1')) : '' }}"
                            aria-label="Reach by whatsapp" class="flex gap-1">
                            <svg class="w-5 h-5" style="color:#28d146">
                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#whatsapp" />
                            </svg>
                            <div class="text-sm">{{ Setting::get('mobile1') ?? '' }}</div>
                        </a>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="flex items-center gap-1">
                        <span class="text-xs text-gray-500">Email</span>
                    </div>
                    <div>
                        <a href="mailto:{{ Setting::get('email') ?? '' }}" class="flex gap-1 text-sm items-center">
                            <x-icons.envelope-simple class="size-5 text-secondary" />
                            {{ Setting::get('email') ?? '' }}
                        </a>
                    </div>
                </div>
            </div>
            <livewire:cart-counter></livewire:cart-counter>

            {{-- Login --}}
            @guest
                <a href="{{ route('login') }}" class="flex-shrink-0"><x-icons.user-circle-fill class="size-8" /></a>
            @endguest
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm rounded-md whitespace-nowrap md:block hidden">
                        Log Out
                    </button>
                </form>
            @endauth
        </div>{{-- Talk to expert --}}

    </div>

</header>{{-- Header --}}

<div class="{{ request()->routeIs('front.trips.*') ? 'relative' : 'sticky' }} top-0 border-b border-white/20 bg-primary z-99"
    x-data="searchDropdown">
    <div class="container relative flex justify-center md:gap-6">

        @include('front.elements.navbar')

        {{-- Search --}}
        <button class="p-3 ml-auto lg:ml-0" x-on:click="searchboxOpen=true;" aria-label="Search">
            <svg class="w-6 h-6 text-primary-light">
                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#search"></use>
            </svg>
        </button>

        {{-- Mobile Nav Button --}}
        <button class="p-3  lg:hidden" x-on:click="mobilenavOpen=!mobilenavOpen"
            :aria-label="`${mobilenavOpen ? 'Close' : 'Open'} mobile navigation`">
            <svg class="w-6 h-6 text-primary-light" x-cloak x-show="!mobilenavOpen">
                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#menu" />
            </svg>
            <svg class="w-6 h-6 text-primary-light" x-cloak x-show="mobilenavOpen">
                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#x" />
            </svg>
        </button>

        <div x-show="searchboxOpen" x-cloak class="absolute w-full max-w-3xl left-1/2 top-[8rem] z-99"
            @click.away="searchboxOpen=false" style="transform: translateX(-50%)">
            @include('front.elements.trip-search-header')
        </div>
    </div>
</div>

@if (!request()->routeIs('front.trip-departures.index'))
    <div class="bg-accent lg:hidden">
        <div class="container py-1 text-center">
            <a href="{{ route('front.trip-departures.index') }}"><span class="font-semibold">Join our fixed departure
                    groups</span>.</a>
        </div>
    </div>
@endif
