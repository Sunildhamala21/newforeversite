<section>
    <div class="relative hero">
        <div id="banner-slider" class="hero-slider">
            @forelse ($banners as $banner)
                <div class="slide banner">
                    <img src="{{ $banner->imageUrl }}" class="object-cover object-top w-full h-80 lg:h-150"
                        alt="{{ $banner->caption }}" width="1600" height="1000">
                    <div class="absolute w-full py-4 text lg:py-6">
                        <div class="container">
                            <div class="flex flex-col mb-8">
                                <div class="font-bold text-white hero-slider-title">
                                    <span>{{ $banner->caption }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Mountain graphics --}}
        <div class="absolute bottom-0 -translate-x-1/2 left-1/2">
            <svg viewbox="0 0 40 6" class="h-4">
                <path d="M0 6 10 2 14 4 20 0 26 4 30 2 40 6 0 6" fill="white">
            </svg>
        </div>

        @include('front.elements.trip-search')

    </div>
</section>
