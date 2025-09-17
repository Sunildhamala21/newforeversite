<!-- Search Widget -->
<div class="search-widget" x-data="{ searchWidgetOpen: false }">
    <button id="search-title" class="fixed shadow-md btn btn-accent" style="right:9rem;bottom:1.5rem;z-index:99" @click="searchWidgetOpen=true">
        Tour Finder
    </button>

    <form action="{{ route('front.trips.search') }}" method="GET" id="search-widget-form" class="fixed bg-white text-primary" x-cloak x-show.transition="searchWidgetOpen"
        style="right:0;top:0;bottom:0;width:18rem;z-index:99" @click.away="searchWidgetOpen=false">
        <div class="flex items-center justify-between px-4 search-widget-header" style="height:3rem">
            <h2 class="text-lg uppercase font-display">Tour Finder</h2>
            <button type="button" @click.prevent="searchWidgetOpen=false">
                <svg class="w-6 h-6">
                    <use xlink:href="{{ asset('assets/front/img/sprite.svg#x') }}" />
                </svg>
            </button>
        </div>

        <div class="p-4 search-widget-body">
            <h2 class="mb-2">
                Destinations
            </h2>
            @foreach ($destinations as $destination)
                <div class="flex flex-wrap items-center mb-4">
                    <input type="checkbox" id="dest-{{ $destination->id }}" name="destination_id" value="{{ $destination->id }}" hidden>
                    <label for="dest-{{ $destination->id }}" class="flex items-center p-2 label-button">
                        <svg class="w-6 h-6 mr-2">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg#check') }}" />
                        </svg>
                        {{ $destination->name }}
                    </label>
                </div>
            @endforeach

            <h2 class="mb-2">
                Activities
            </h2>
            @foreach ($activities as $activity)
                <div class="mb-4">
                    <input type="checkbox" name="activity_id" id="act-{{ $activity->id }}" value="{{ $activity->id }}" hidden>
                    <label class="flex p-1 custom-check" for="act-{{ $activity->id }}">
                        <svg class="w-6 h-6 mr-2">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg#check') }}" />
                        </svg>
                        {{ $activity->name }}
                    </label>
                </div>
            @endforeach
            <h2 class="mb-2">
                Duration
            </h2>
            <div class="mb-4">
                <input type="radio" name="duration" id="dur1" value="any" hidden checked>
                <label class="flex p-1 custom-check" for="dur1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2">
                        <circle cx="10" cy="10" r="5" fill="none" stroke="currentColor" stroke-width="2">
                    </svg>
                    Any
                </label>
                <input type="radio" name="duration" id="dur2" value="1" hidden>
                <label class="flex p-1 custom-check" for="dur2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2">
                        <circle cx="10" cy="10" r="5" fill="none" stroke="currentColor" stroke-width="2">
                    </svg>
                    1 day
                </label>
                <input type="radio" name="duration" id="dur3" value="2-7" hidden>
                <label class="flex p-1 custom-check" for="dur3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2">
                        <circle cx="10" cy="10" r="5" fill="none" stroke="currentColor" stroke-width="2">
                    </svg>
                    2 - 7 days
                </label>
                <input type="radio" name="duration" id="dur4" value="8-30" hidden>
                <label class="flex p-1 custom-check" for="dur4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2">
                        <circle cx="10" cy="10" r="5" fill="none" stroke="currentColor" stroke-width="2">
                    </svg>
                    8 days - 1 month
                </label>
                <input type="radio" name="duration" id="dur5" value="30-365" hidden>
                <label class="flex p-1 custom-check" for="dur5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2">
                        <circle cx="10" cy="10" r="5" fill="none" stroke="currentColor" stroke-width="2">
                    </svg>
                    1 month - 1 year
                </label>
            </div>
        </div>

        <div class="flex items-center justify-center search-widget-footer" style="height:5rem">
            <button class="btn btn-primary" data-target="#search-widget-form">
                Find Tour
                <svg class="w-6 h-4">
                    <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowright') }}" />
                </svg>
            </button>
        </div>
    </form>
</div>
<!-- Search Widget -->
