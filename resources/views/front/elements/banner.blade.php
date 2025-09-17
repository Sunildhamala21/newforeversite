@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tiny-slider@2.9.3/dist/tiny-slider.css">
@endpush

<section>
    <div class="relative hero">
        <!-- Slider -->
        <div id="banner-slider" class="hero-slider">
            @forelse ($block_1_trips as $banner)
                <div class="relative slide banner">
                    <img src="{{ $banner->thumbImageUrl }}" data-img="{{ $banner->imageUrl }}" class="block lazyload" alt="{{ $banner->name }}" width="1500" height="1000">
                    <div class="absolute w-full py-4 text lg:py-6">
                        <div class="container">
                            <div class="flex flex-col mb-4">
                                <div class="mb-2 text-2xl italic text-white lg:text-5xl">
                                    <span>{{ $banner->duration }} days</span>
                                </div>
                                <h2 class="font-bold text-white uppercase hero-slider-title">
                                    <span>{{ $banner->name }}</span>
                                </h2>
                            </div>

                            <div class="buttons">
                                <a href="{{ route('front.trips.show', ['slug' => $banner->slug]) }}" class="btn btn-primary">
                                    Explore
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div><!-- Slider -->

        <div class="absolute hero-slider-controls none md:block">
            <div class="container flex flex-col gap-10">
                <button>
                    <svg class="w-6 h-6">
                        <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowleft') }}" />
                    </svg>
                </button>
                <button>
                    <svg class="w-6 h-6">
                        <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowright') }}" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="absolute bottom-0 -translate-x-1/2 left-1/2">
            <svg viewbox="0 0 40 6" class="h-12">
                <path d="M0 6 10 2 14 4 20 0 26 4 30 2 40 6 0 6" fill="white">
            </svg>
        </div>

        <div class="absolute left-0 w-full banner-search-container">
            <div class="container">
                <form action="{{ route('front.trips.search') }}" id="banner-search-from">
                    <div class="flex">
                        <input id="banner-search" class="px-10 py-2 text-gray-700 placeholder-gray-500 bg-white border-0 focus:placeholder-transparent lg:text-lg" type="text" name="keyword"
                            placeholder="Search Keywords" aria-label="Search site" style="min-width:0;">
                        <button class="px-4 py-3 lg:text-xl font-medium tracking-wider text-gray-100 rounded-md bg-accent hover:bg-blue-600 focus:bg-blue-600 focus:outline-hidden">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- Hero -->
</section>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tiny-slider@2.9.3/dist/tiny-slider.min.js"></script>

    <script>
        const heroSlider = tns({
            mode: 'gallery',
            container: '.hero-slider',
            nav: false,
            controlsContainer: '.hero-slider-controls .container',
            autoplay: true,
            autoplayButtonOutput: false
        })
    </script>
@endpush
