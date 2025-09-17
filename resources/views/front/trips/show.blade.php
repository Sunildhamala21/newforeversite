<?php
$mapImageUrl = $trip->mapImageUrl;
if (session()->has('success_message')) {
    $session_success_message = session('success_message');
    session()->forget('success_message');
}

if (session()->has('error_message')) {
    $session_error_message = session('error_message');
    session()->forget('error_message');
}
?>
@extends('layouts.front_inner')
@section('meta_og_title'){!! $trip->trip_seo->meta_title ?? '' !!}@stop
@section('meta_description'){!! $trip->trip_seo->meta_description ?? '' !!}@stop
@section('meta_keywords'){!! $trip->trip_seo->meta_keywords ?? '' !!}@stop
@section('meta_og_url'){!! $trip->trip_seo->canonical_url ?? '' !!}@stop
@section('meta_og_description'){!! $trip->trip_seo->meta_description ?? '' !!}@stop
@section('meta_og_image'){!! $trip->trip_seo->ogImageUrl ?? $trip->imageUrl !!}@stop

    @php
        $tripSchemaReviews = [];
        foreach ($trip->trip_reviews as $review) {
            $reviewSchema = Spatie\SchemaOrg\Schema::review()
                ->name($review->title)
                ->author(Spatie\SchemaOrg\Schema::person()->name($review->review_name))
                ->datePublished($review->created_at)
                ->reviewBody($review->review)
                ->reviewRating(
                    Spatie\SchemaOrg\Schema::rating()
                        ->ratingValue(strip_tags($review->rating))
                        ->bestRating(5)
                        ->worstRating(1),
                );
            $tripSchemaReviews[] = $reviewSchema;
        }
        $tripSchema = Spatie\SchemaOrg\Schema::Product()
            ->name($trip->name)
            ->url(route('front.trips.show', $trip))
            ->image($trip->imageUrl)
            ->description(
                $trip->trip_seo?->meta_description ?? strip_tags($trip->description),
            )
            ->offers(Spatie\SchemaOrg\Schema::Offer()->price($trip->cost)->priceCurrency('USD'))
            ->review($tripSchemaReviews)
            ->aggregateRating(
                Spatie\SchemaOrg\Schema::aggregateRating()
                    ->ratingValue($trip->trip_reviews->avg('rating'))
                    ->reviewCount($trip->trip_reviews->count()),
            );
        $tripQuestions = [];
        if ($trip->trip_faqs->count()) {
            foreach ($trip->trip_faqs as $question) {
                $tripQuestions[] = Spatie\SchemaOrg\Schema::Question()
                    ->name($question->title)
                    ->acceptedAnswer(Spatie\SchemaOrg\Schema::Answer()->text($question->description));
            }
            $tripFaqSchema = Spatie\SchemaOrg\Schema::FAQPage()->mainEntity($tripQuestions);
        }

    @endphp
    @push('schema')
        {!! $tripSchema->toScript() !!}
    @endpush
    @push('styles')
        <script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>

        <style>
            .blocker {
                z-index: 10000 !important;
            }

            .embed-container {
                position: relative;
                padding-bottom: 56.25%;
                height: 0;
                overflow: hidden;
                max-width: 100%;
            }

            .embed-container iframe,
            .embed-container object,
            .embed-container embed {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            .modal {
                z-index: 99999 !important;
            }

            .modal-body {
                /* 100% = dialog height, 120px = header + footer */
                /*height: 70vh;*/
                /*overflow-y: scroll;*/
            }

            .trip-map-iframe {
                display: flex;
            }

            canvas#ctx {
                background: center / cover url(/assets/front/img/mountains.jpg);
            }

            .tour-details #overview-text a {
                font-weight: 600;
                text-decoration: none;
            }

            .tour-details .trip-info {
                font-weight: 600;
                text-decoration: none;
            }
        </style>
    @endpush

    @push('scripts')
        @vite(['resources/js/trip-details.js'])
    @endpush
@section('content')

    <section class="bg-gray-50">
        {{-- Sticky Nav --}}
        <div class="sticky top-0 tdb bg-primary-light z-98">
            <div class="container">
                <nav class="flex items-center tour-details-tabs" id="secondnav">
                    <ul class="flex flex-wrap gap-1 py-1 nav text-primary">
                        <x-front.trip-details.scrollspy-nav name="Overview" icon="icons.squares-four" />

                        @if (!$trip->trip_itineraries->isEmpty())
                            <x-front.trip-details.scrollspy-nav name="Itinerary" icon="icons.calendar-dots" />
                        @endif

                        @if ($trip->trip_sliders->count() > 0)
                            <x-front.trip-details.scrollspy-nav name="Gallery" icon="icons.image" />
                        @endif

                        @if ($trip->trip_include_exclude)
                            <x-front.trip-details.scrollspy-nav name="Includes/Excludes" icon="icons.tag" />
                        @endif

                        @if ($trip->trip_include_exclude ? $trip->trip_include_exclude->complimentary : '')
                            <x-front.trip-details.scrollspy-nav name="Trip Info" icon="icons.info" />
                        @endif

                        @if (!$trip->trip_departures->isEmpty())
                            <x-front.trip-details.scrollspy-nav name="Date & Price" icon="icons.calendar-heart" />
                        @endif

                        @if ($trip->trip_reviews->count())
                            <x-front.trip-details.scrollspy-nav name="Reviews" icon="icons.chat-circle-text" />
                        @endif

                        @if ($trip->trip_seo?->about_leader)
                            <x-front.trip-details.scrollspy-nav name="Packing List" icon="icons.backpack" />
                        @endif

                        @if ($trip->trip_faqs->count())
                            <x-front.trip-details.scrollspy-nav name="FAQs" icon="icons.question" />
                        @endif
                    </ul>
                </nav>
            </div>
            <div id="tourDetailsBarIO"></div>
        </div>{{-- Sticky Nav --}}

        <div class="container pt-10 pb-20">

            <div class="gap-10 lg:grid lg:grid-cols-3 xl:gap-20">

                <div class="tour-details lg:col-span-2">

                    @include('front.elements.breadcrumb', [
                        'navs' => [],
                        'current' => $trip->name,
                    ])

                    <div class="flex flex-wrap items-center justify-between gap-10 mt-6 mb-10">
                        <div>
                            <h1 class="mb-4 text-xl font-semibold lg:text-3xl font-display">{{ $trip->name }}</h1>
                            <ul class="flex gap-4 text-sm">
                                <li class="flex gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="w-6 h-6 -mt-1 text-green-500 shrink-0"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                    </svg>
                                    Best price guaranteed
                                </li>
                                <li class="flex gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="w-6 h-6 -mt-1 text-green-500 shrink-0"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                    </svg>
                                    No booking fees
                                </li>
                                <li class="flex gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="w-6 h-6 -mt-1 text-green-500 shrink-0"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                    </svg>
                                    Book Now, Pay Later
                                </li>
                            </ul>
                        </div>
                        <div class="shrink-0">
                            <div class="flex gap-1">
                                @for ($i = 0; $i < $trip->rating; $i++)
                                    <svg class="w-5 h-5 text-accent">
                                        <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#star" />
                                    </svg>
                                @endfor

                                @for ($i = 0; $i < 5 - $trip->rating; $i++)
                                    <svg class="w-5 h-5 text-accent" viewbox="0 0 20 20" stroke="currentColor"
                                        fill="none">
                                        <path stroke-linecap="round" stroke-width="1.5"
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor
                            </div>
                            <div class="text-sm text-right text-gray-500">from {{ $trip->reviews_count }} reviews</div>
                        </div>
                    </div>

                    {{-- Slider --}}
                    <section class="relative mb-10 group">
                        <div id="hero-slider" class="overflow-hidden rounded-lg">
                            @if (iterator_count($trip->trip_galleries))
                                @foreach ($trip->trip_galleries as $gallery)
                                    <div class="slide">
                                        <img data-src="{{ $gallery->imageUrl }}" class="object-cover w-full tns-lazy-img"
                                            alt="{{ $gallery->alt_tag }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="hidden group-hover:block">
                            <div class="hidden hero-slider-controls md:block">
                                <button
                                    class="absolute p-2 -translate-y-1/2 rounded-sm top-1/2 left-4 bg-white/60 hover:bg-white/80">
                                    <svg class="w-5 h-5">
                                        <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowleft') }}" />
                                    </svg>
                                </button>
                                <button
                                    class="absolute p-2 -translate-y-1/2 rounded-sm top-1/2 right-4 bg-white/60 hover:bg-white/80">
                                    <svg class="w-5 h-5">
                                        <use xlink:href="{{ asset('assets/front/img/sprite.svg#arrownarrowright') }}" />
                                    </svg>
                                </button>
                            </div>
                            <div id="slider-nav" class="absolute flex flex-wrap justify-center w-full gap-2 bottom-4">
                                @foreach ($trip->trip_galleries as $gallery)
                                    <button>
                                        <img src="{{ $gallery->thumbImageUrl }}" class="h-12 border border-white"
                                            alt="{{ $gallery->alt_tag }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>

                    </section>

                    <div class="lg:hidden">
                        @include('front.elements.price_card')
                    </div>

                    <div id="overview" class="px-4 py-10 mb-20 bg-white border-2 border-gray-100 rounded-lg tds lg:px-10">
                        <div>

                            <div class="grid gap-6 mb-6 md:grid-cols-2 lg:grid-cols-6">

                                @if (!empty($trip->max_altitude))
                                    <div class="flex lg:col-span-2">
                                        <div class="mr-4">
                                            <svg class="w-10 h-10 text-primary">
                                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#maxelevation" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray">
                                                Max. Elevation
                                            </div>
                                            <div>
                                                {{ $trip->max_altitude }} m / {{ floor($trip->max_altitude * 3.28084) }}
                                                ft
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($trip->group_size))
                                    <div class="flex lg:col-span-2">
                                        <div class="mr-4">
                                            <svg class="w-10 h-10 text-primary">
                                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#groupsize" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray">
                                                Group size
                                            </div>
                                            <div>
                                                {{ $trip->group_size ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($trip->difficulty_grade_value))
                                    <div class="flex lg:col-span-2">
                                        <div class="mr-4">
                                            <svg class="w-10 h-10 text-primary">
                                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#level" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray">
                                                Level
                                            </div>
                                            <div>
                                                {{ $trip->difficulty_grade_value }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($trip->trip_info->transportation))
                                    <div class="flex lg:col-span-2">
                                        <div class="mr-4">
                                            <svg class="w-10 h-10 text-primary">
                                                <use
                                                    xlink:href="{{ asset('assets/front/img/sprite.svg') }}#transportation" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray">
                                                Transportation
                                            </div>
                                            <div>
                                                {{ $trip->trip_info->transportation ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($trip->trip_info->best_season))
                                    <div class="flex lg:col-span-2">
                                        <div class="mr-4">
                                            <svg class="w-10 h-10 text-primary">
                                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#bestseason" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray">
                                                Best Season
                                            </div>
                                            <div>
                                                {{ $trip->trip_info->best_season ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($trip->starting_point) && !empty($trip->ending_point))
                                    <div class="flex lg:col-span-2">
                                        <div class="mr-4">
                                            <svg class="w-10 h-10 text-primary">
                                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#startsat" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray">
                                                Starts at / Ends at
                                            </div>
                                            <div>
                                                {{ $trip->starting_point ?? '' }} / {{ $trip->ending_point ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($trip->trip_info->accomodation))
                                    <div class="flex lg:col-span-3">
                                        <div class="mr-4">
                                            <svg class="w-10 h-10 text-primary">
                                                <use
                                                    xlink:href="{{ asset('assets/front/img/sprite.svg') }}#accomodation" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray">
                                                Accomodation
                                            </div>
                                            <div>
                                                {{ $trip->trip_info->accomodation ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($trip->trip_info->meals))
                                    <div class="flex lg:col-span-3">
                                        <div class="mr-4">
                                            <svg class="w-10 h-10 text-primary">
                                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#meals" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray">
                                                Meals
                                            </div>
                                            <div>
                                                {{ $trip->trip_info->meals ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($trip->trip_info->trip_route))
                                    <div class="flex lg:col-span-6">
                                        <div class="mr-4">
                                            <svg class="w-10 h-10 text-primary">
                                                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#triproute" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray">
                                                Trip Route
                                            </div>
                                            <div>
                                                {{ $trip->trip_info->trip_route ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <div class="">

                                <h2 class="mb-2 text-2xl font-display text-primary">Highlights</h2>
                                <div class="mb-4 highlights">
                                    {!! $trip->trip_info ? $trip->trip_info->highlights : '' !!}
                                </div>

                                <div id="overview-text" x-data="{ expanded: false }" class="relative mb-4 prose">
                                    <h2 class="sr-only">Overview</h2>
                                    <x-collapsible-content :content="$trip->trip_info?->overview ?? ''" />
                                </div>

                                @if ($trip->trip_info?->important_note)
                                    <div class="p-4 mb-3 rounded-sm bg-light">
                                        <h3 class="mb-2 text-xl font-display text-primary"> Important Note</h3>
                                        <p class="mb-0 text-sm">
                                            {!! $trip->trip_info ? $trip->trip_info->important_note : '' !!}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div id="itinerary" class="p-4 mb-20 bg-white border-2 border-gray-100 rounded-lg tds lg:p-10"
                        x-data="{
                            showOutline: true,
                            day1Open: true,
                            @for ($i = 1; $i < $trip->trip_itineraries->count() ; $i++)
                        day{{ $i + 1 }}Open:false, @endfor
                        }">
                        <div class="flex flex-wrap items-end justify-between gap-4 mb-6">
                            <h2 class="text-2xl uppercase lg:text-3xl font-display text-primary">Trip Itinerary</h2>
                            <div>
                                {{-- blade-formatter-disable --}}
                                <button class="mb-2 btn btn-sm btn-primary" x-cloak x-show="showOutline" x-on:click="@for($i = 0; $i < $trip->trip_itineraries->count(); $i++) day{{ $i + 1 }}Open = @endfor true; showOutline=false">
                                    Expand All
                                </button>
                                <button class="mb-2 btn btn-sm btn-primary collapse-all" x-cloak x-show="!showOutline" x-on:click="@for ($i = 0; $i < $trip->trip_itineraries->count() ; $i++) day{{ $i + 1 }}Open = @endfor false; showOutline=true">
                                    Collapse All
                                </button>
                                {{-- blade-formatter-enable --}}
                            </div>
                        </div>

                        <div class="relative mb-4 itinerary">
                            <div class="absolute border-l border-dashed border-primary top-8 bottom-8"></div>
                            @foreach ($trip->trip_itineraries as $i => $itinerary)
                                <div class="relative pl-4">
                                    @if ($loop->last)
                                        <div class="absolute left-0 border-l border-white top-8 bottom-8"></div>
                                    @endif
                                    <button type="button"
                                        class="w-full text-left py-3 @if (!$loop->first) border-t @endif border-gray-300 hover:text-primary relative"
                                        x-on:click="day{{ $i + 1 }}Open = !day{{ $i + 1 }}Open ">
                                        <div
                                            class="absolute w-4 h-4 bg-white border-2 rounded-full -left-6 top-5 border-primary">
                                        </div>
                                        <div class="flex items-center justify-between gap-2 text-xl font-display">
                                            <h3 class="text-xl font-display">Day {{ $itinerary->day }}:
                                                {{ $itinerary->name }}</h3>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="w-6 h-6 transition shrink-0"
                                                x-bind:class="{ 'rotate-180': day{{ $i + 1 }}Open }"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                            </svg>
                                        </div>
                                    </button>

                                    <div class="pt-2 pb-10" x-cloak x-show.transition="day{{ $i + 1 }}Open">
                                        <div class="">
                                            @if (isset($itinerary->image_name) && !empty($itinerary->image_name))
                                                <a href="{{ $itinerary->imageUrl }}"
                                                    data-fancybox="image{{ $i }}"
                                                    class="mt-2 mb-2 xl:w-1/2 {{ $i % 2 == 0 ? 'xl:float-left mr-4' : 'xl:float-right ml-4' }}">
                                                    <img src="{{ $itinerary->imageUrl }}" alt="{{ $itinerary->name }}"
                                                        loading="lazy">
                                                </a>
                                            @endif
                                            <div class="lim">
                                                {!! $itinerary->description !!}
                                            </div>
                                        </div>
                                        {{-- icons --}}
                                        <div class="flex flex-col clear-both gap-10 mt-4 md:flex-row">
                                            @if (trim($itinerary->max_altitude) !== '')
                                                <div class="flex gap-2">
                                                    <img src="{{ asset('assets/front/img/elevation.png') }}"
                                                        alt="{{ $trip->name }}" class="w-6 h-6">
                                                    <div>
                                                        <h4 class="text-sm uppercase font-display">Max. altitude</h4>
                                                        <div class="">
                                                            {{ number_format((float) $itinerary->max_altitude) }}m /
                                                            {{ number_format((float) $itinerary->max_altitude * 3.28084) }}
                                                            ft.
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (trim($itinerary->accomodation) !== '')
                                                <div class="flex gap-2">
                                                    <img src="{{ asset('assets/front/img/accomodation.png') }}"
                                                        alt="{{ $trip->name }}" class="w-6 h-6">
                                                    <div>
                                                        <h4 class="text-sm uppercase font-display">Accommodation</h4>
                                                        <div class="">{{ $itinerary->accomodation }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (trim($itinerary->meals) !== '')
                                                <div class="flex gap-2">
                                                    <img src="{{ asset('assets/front/img/meal.png') }}"
                                                        alt="{{ $trip->name }}" class="w-6 h-6">
                                                    <div>
                                                        <h4 class="text-sm uppercase font-display">Meals</h4>
                                                        <div class="">{{ $itinerary->meals }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--</div>-->
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- not satisfied --}}
                        <div
                            class="flex flex-wrap items-center justify-between gap-2 px-4 py-3 border rounded-lg border-primary lg:px-10 bg-light">
                            <div class="flex gap-4 grow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="w-5 h-5 shrink-0 text-primary" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8" />
                                </svg>
                                <div>
                                    Not satisfied with this itinerary? <b class="text-primary">Make your own</b>.
                                </div>
                            </div>
                            <a href="{{ route('front.plantrip.createfortrip', $trip->slug) }}"
                                class="btn btn-sm btn-primary">Plan My Trip</a>
                        </div>
                    </div>

                    {{-- Elevation Chart --}}
                    @include('front.elements.elevation_chart')

                    {{-- Route Map --}}
                    @if ($trip->map_file_name)
                        <div class="mb-8">
                            <h2 class="text-2xl uppercase lg:text-3xl font-display text-primary">Route Map</h2>
                            <a href="{{ $trip->mapImageUrl }}" data-fancybox>
                                <img class="img-fluid" src="{{ $trip->mapImageUrl }}" alt="{{ $trip->name }}"
                                    loading="lazy">
                            </a>
                        </div>
                    @endif

                    @if (!empty($trip->iframe))
                        <div class="mb-8">
                            <div class="card-header">
                                <h2 class="mb-2 text-2xl uppercase font-display text-primary">Map</h2>
                            </div>
                            <div class="p-0 card-body">
                                <!-- Link to open the modal -->
                                <div class="trip-map-iframe">
                                    {!! $trip->iframe !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Gallery --}}
                    @if ($trip->trip_sliders->count() > 0)
                        <div id="gallery" class="p-4 mb-20 bg-white border-2 border-gray-100 rounded-lg tds lg:p-10">
                            <h2 class="mb-6 text-2xl uppercase lg:text-3xl font-display text-primary">Gallery</h2>
                            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                                @foreach ($trip->trip_sliders as $gallery)
                                    <a href="{{ $gallery->imageUrl }}" data-fancybox="tripGallery">
                                        <img src="{{ $gallery->imageUrl }}" alt="{{ $gallery->alt_tag }}"
                                            loading="lazy" class="object-cover aspect-square">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    {{-- Gallery --}}

                    {{-- include exclude --}}
                    <div id="includesexcludes" class="p-4 mb-20 bg-white border-2 border-gray-100 rounded-lg tds lg:p-10">
                        @if ($trip->trip_include_exclude)
                            <div class="grid gap-10 lg:grid-cols-2">
                                <div>
                                    <h2 class="mb-6 text-2xl uppercase lg:text-3xl font-display text-primary">Includes</h2>
                                    <div class="includes">
                                        <?= $trip->trip_include_exclude->include ?>
                                    </div>
                                </div>

                                <div>
                                    <h2 class="mb-6 text-2xl uppercase lg:text-3xl font-display text-primary">Doesn't
                                        Include</h2>
                                    <div class="excludes">
                                        <?= $trip->trip_include_exclude->exclude ?>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- include exclude --}}

                    {{-- Trip Info --}}
                    @if ($trip->trip_include_exclude && !empty($trip->trip_include_exclude->complimentary))
                        <div id="trip-info" class="relative px-4 pt-10 pb-4 mb-4 prose bg-white rounded-lg tds lg:px-10"
                            style="max-width: 100ch;">
                            <h2 class="mb-6 text-2xl uppercase lg:text-3xl font-display text-primary">Trip Info</h2>
                            <p> <?= $trip->trip_include_exclude->complimentary ?> </p>

                        </div>
                    @endif

                    {{-- departures --}}
                    @if (!$trip->trip_departures->isEmpty())
                        <div id="date-price" class="mb-10 tds">
                            <div class="flex flex-wrap items-center justify-between gap-10 mb-4">
                                <h2 class="mb-6 text-2xl uppercase lg:text-3xl font-display text-primary">Upcoming
                                    Departure Dates
                                </h2>
                                <div class="flex gap-2">
                                    <button id="group-departure"
                                        class="flex items-center gap-2 p-2 text-sm bg-white border border-gray-200 rounded-sm hover:text-primary hover:border-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="w-4 h-4" viewBox="0 0 16 16">
                                            <path
                                                d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                        </svg>
                                        Group departures
                                    </button>
                                    <button id="private-departure"
                                        class="flex items-center gap-2 p-2 text-sm bg-white border rounded-sm hover:text-primary hover:border-primary border-primary text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="w-4 h-4" viewBox="0 0 16 16">
                                            <path
                                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z" />
                                        </svg>
                                        Private departures
                                    </button>
                                </div>
                            </div>
                            <?php
                            $currentYear = date('Y');
                            $currentMonth = date('n');
                            $monthsArray = [];
                            for ($i = 0; $i < 24; $i++) {
                                $year = $currentYear;
                                if ($currentMonth > 12) {
                                    $currentMonth -= 12;
                                    $year++;
                                    $currentYear = $year;
                                }
                                $monthsArray[] = strtotime("$year-$currentMonth-01");
                                $currentMonth = $currentMonth + 1;
                            }
                            ?>

                            <div id="all-dates-block" class="grid grid-cols-4 gap-2 mb-4 md:grid-cols-6 lg:grid-cols-9">
                                <button id="all-departure-filter"
                                    class="p-2 px-4 py-2 font-semibold text-center text-white border rounded-sm departure-date-active border-primary bg-primary">
                                    All <br>Dep
                                </button>
                                @foreach ($monthsArray as $month)
                                    <button data-date="{{ $month }}"
                                        class="p-2 px-4 py-2 font-semibold text-center text-gray-500 bg-white border border-gray-200 rounded-sm select-date-departure hover:border-primary hover:text-primary">{{ Str::replaceFirst('-', '<br>', date('M Y', $month)) }}
                                    </button>
                                @endforeach
                            </div>
                            <div class="grid gap-4 mb-6">
                                @php
                                    $trip_departures = $trip->trip_departures;
                                @endphp
                                <div id="departure-filter-block" class="grid gap-4">
                                    @foreach ($trip->trip_departures as $departure)
                                        {{-- <div
                                             class="grid grid-cols-2 gap-4 px-4 py-3 bg-white border-2 border-gray-100 rounded-lg lg:px-10 lg:grid-cols-5 hover:border-primary">
                                            <div>
                                                <div class="font-semibold">{{ formatDate($departure->from_date) }}</div>
                                                <span class="text-sm text-gray-500">From {{ $trip->starting_point }}</span>
                                            </div>
                                            <div>
                                                <div class="font-semibold">{{ formatDate($departure->to_date) }}</div>
                                                <span class="text-sm text-gray-500">To {{ $trip->ending_point }}</span>
                                            </div>
                                            <div>
                                                <div class="font-semibold">{{ $departure->seats }}</div>
                                                <div class="text-sm text-gray-500">seats left</div>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold">From <span class="text-red-500"><s>{{ number_format($trip->cost) }}</s></span>
                                                </div>
                                                <div class="font-semibold">US$ {{ number_format($departure->price) }}</div>
                                                <div class="text-sm text-green-600">Saving US$ {{ number_format($trip->cost - $departure->price) }}</div>
                                            </div>
                                            <div class="self-center col-span-2 lg:col-span-1">
                                                <a href="{{ route('front.trips.departure-booking', ['slug' => $trip->slug, 'id' => $departure->id]) }}"
                                                   class="inline-block w-full px-3 py-2 text-sm text-center transition border rounded-sm border-primary hover:bg-primary hover:text-white">Join
                                                    Now</a>
                                            </div>
                                        </div> --}}
                                    @endforeach
                                </div>
                            </div>

                            {{-- bicky --}}
                            <div style=" display: flex; justify-content: center;">
                                <button id="show-more-departure-button" style="display: none;"
                                    class="px-4 py-2 text-xs rounded-full bg-light">Show more</button>
                            </div>
                        </div>
                    @endif
                    {{-- departures end --}}

                    {{-- Why book with us --}}
                    <div class="p-4 mb-20 border bg-light border-primary" x-data="{ isExpanded: false }">
                        <div class="mb-2 text-xl uppercase font-display">Why Book with Us?</div>

                        @php
                            $listItems = [
                                'Excellent customer service. Our travel experts are ready to help you 24/7.',
                                'Best price guaranteed.',
                                'No credit card or booking fees.',
                                '100% financial protection. ',
                                'Environmentally-friendly tours.',
                            ];
                        @endphp
                        <ul class="grid grid-cols-2 gap-2 mb-2">
                            @foreach ($listItems as $item)
                                @if ($loop->index < 6)
                                    <li class="relative pl-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="absolute left-0 w-4 h-4 text-primary top-1"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                        </svg>
                                        {!! $item !!}
                                    </li>
                                @else
                                    <div class="col-span-2" x-show="isExpanded">
                                        <li class="relative pb-2 pl-6">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="absolute left-0 w-4 h-4 text-primary top-1"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                            </svg>
                                            {!! $item !!}
                                        </li>
                                    </div>
                                @endif
                            @endforeach
                            {{-- li elements after the 6th --}}
                        </ul>
                        @if (count($listItems) > 6)
                            <div class="text-sm text-primary">
                                <button x-on:click="isExpanded=true" x-show="!isExpanded">Read more reasons to book with
                                    us</button>
                                <button x-on:click="isExpanded=false" x-show="isExpanded">Read less</button>
                            </div>
                        @endif
                    </div>
                    {{-- Why book --}}

                    {{-- reviews --}}
                    @if (iterator_count($trip->trip_reviews))
                        <div id="reviews" class="mb-20 tds">
                            <div class="items-center justify-between mb-4 lg:flex">
                                <h2 class="text-2xl uppercase lg:text-3xl font-display text-primary">Reviews</h2>

                                <div>
                                    <a href="{{ route('front.reviews.create') }}" class="mr-1 btn btn-primary btn-sm"
                                        data-toggle="modal" data-target="#review-modal">
                                        Write a review</a>
                                </div>
                            </div>
                            <div class="grid gap-4 mb-4">
                                @foreach ($trip->trip_reviews()->where('status', 1)->get() as $review)
                                    <div class="p-4 bg-white border-2 border-gray-100 rounded-lg lg:p-10 review">
                                        <div class="mb-4 review__content">
                                            <h3 class="mb-2 text-2xl font-display text-primary">{{ $review->title }}</h3>
                                            <p>{{ $review->review }}</p>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            @if ($review->thumbImageUrl)
                                                <img src="{{ $review->thumbImageUrl }}" alt="{{ $review->review_name }}"
                                                    loading="lazy">
                                            @else
                                                <div
                                                    class="flex items-center justify-center w-16 h-16 text-xl rounded-full bg-light text-primary">
                                                    {{ $review->review_name[0] }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold">{{ $review->review_name }}</div>
                                                <div class="text-sm text-gray">{{ $review->review_country }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <a href="{{ route('front.reviews.index') }}" class="underline text-primary">See more
                                reviews</a>
                        </div>
                    @endif
                    {{-- reviews end --}}

                    {{-- Equipment List --}}
                    @if ($trip->trip_seo?->about_leader)
                        <div id="packing-list" class="p-4 mb-20 bg-white border-2 border-gray-100 rounded-lg tds lg:p-10">
                            <h2 class="mb-4 text-3xl uppercase lg:text-4xl font-display text-primary">Packing List</h2>
                            <div class="prose">
                                {!! $trip->trip_seo?->about_leader !!}
                            </div>
                        </div>
                    @endif
                    {{-- Equipment List --}}

                </div>

                {{-- aside --}}
                <aside>
                    <div id="aside-contents">
                        <div>
                            @include('front.elements.price_card')
                            @include('front.elements.enquiry')
                            <button x-on:click="showModal = true"
                                class="w-full px-4 py-3 uppercase border border-gray-400 rounded-lg">Quick Enquiry</button>
                        </div>
                        <div class="p-4 mt-6 bg-white border-2 border-gray-100 rounded-lg price-card">
                            <div class="mb-4 font-bold">
                                Tour with Flexible Booking Policy
                            </div>
                            @php
                                $listItems = [
                                    '<b>Change dates</b><br>It is free to change your tour start date before 30 days of departure.',
                                    '<b>Choose a different tour</b><br>You can select any new tour or similar or different packages up to 30 days before departure.',
                                ];
                            @endphp
                            <ul>
                                @foreach ($listItems as $item)
                                    <li class="flex gap-2 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="w-8 h-8 -mt-1 text-green-500 shrink-0"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                        </svg>
                                        <div class="text-sm prose">
                                            {!! $item !!}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div id="sticky-price" class="sticky hidden top-20">
                        @include('front.elements.price_card')
                    </div>

                </aside>
            </div>
        </div>

        {{-- faqs --}}
        @if ($trip->trip_faqs->count())
            <div id="faqs" class="my-10 tds lg:mb-0 container">
                <h2 class="mb-4 text-2xl uppercase lg:text-3xl font-display text-primary">Frequently Asked
                    Questions</h2>

                <div class="grid-cols-3 gap-10 md:grid">
                    <div>
                        <ul
                            class="sticky flex md:block gap-6 p-4 md:p-8 rounded-lg overflow-scroll bg-light top-11 -mx-4 w-[calc(100%+2rem)]">
                            @foreach ($tripFaqs as $categoryId => $faqs)
                                @php
                                    $category = $faqs->first()->faqCategory;
                                @endphp
                                @if ($category)
                                    <li class="py-2 whitespace-nowrap">
                                        <a href="#faq-{{ str($category->name)->slug() }}"
                                            class="flex gap-2 font-semibold">
                                            @if ($category->icon)
                                                <x-dynamic-component :component="str($category->icon)->prepend('icon-')" class="size-6 text-primary" />
                                            @else
                                                <x-dynamic-component component="icon-question-fill"
                                                    class="size-6 text-primary" />
                                            @endif
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="grid gap-2 mb-6 md:col-span-2">
                        @foreach ($tripFaqs as $categoryId => $faqs)
                            @php
                                $category = $faqs->first()->faqCategory;
                            @endphp
                            <h3 class="mt-4 text-xl font-semibold" id="faq-{{ str($category?->name)->slug() }}">
                                {{ $category?->name }}</h3>
                            <div class="grid gap-1 mt-2" x-data="{ show: 'limited' }">
                                @foreach ($faqs as $faq)
                                    <div class="bg-white border-2 border-gray-100 rounded-lg" x-data="{ active: false }"
                                        @if ($loop->index > 10) x-show="show==='all'" @endif x-cloak>
                                        <button class="flex items-center justify-between w-full px-4 py-3 text-left"
                                            @click="active=!active">
                                            <h3 class="font-semibold text-gray-500">{{ $faq->title }}</h3>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="w-6 h-6 text-gray-400 transition shrink-0"
                                                :class="{ 'rotate-180': active === {{ $loop->index }} }"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                            </svg>
                                        </button>
                                        <div x-cloak x-collapse x-show.transition="active">
                                            <div class="p-4 mb-0 prose">
                                                {!! $faq->description !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($faqs->count() > 10)
                                    <div class="flex justify-center">
                                        <button x-on:click="show=show=='all'?'limited':'all'"
                                            class="px-2 py-1 text-sm bg-white border rounded border-black/10"
                                            x-text="show=='all'?'Less FAQs':'More FAQs'">More
                                            FAQs</button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        @endif

        @if (iterator_count($trip->addon_trips))
            <div class="container mb-8 mt-10 sm:mt-20">
                <h2 class="mb-2 text-2xl uppercase font-display text-primary">Add-on Trips</h2>
                <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 lg:gap-10">
                    @forelse ($trip->addon_trips as $addon_trip)
                        @include('front.elements.addon_trip', ['trip' => $addon_trip])
                    @empty
                    @endforelse
                </div>
            </div>
        @endif

        <!-- Similar -->
        @if (!$trip->similar_trips->isEmpty())
            <div class="py-10 bg-light ">
                <div class="container">
                    <h2 class="mb-2 text-2xl uppercase lg:text-3xl font-display text-primary">Similar Trips</h2>
                    <div class="grid gap-4 lg:grid-cols-3 lg:gap-10">
                        @forelse ($trip->similar_trips as $s_trip)
                            @include('front.elements.tour-card', ['tour' => $s_trip])
                        @empty
                        @endforelse
                    </div>
                </div>
            </div> <!-- Similar -->
        @endif
    </section>

@endsection
@push('scripts')
    <script>
        window.onload = function() {

            var session_success_message = '{{ $session_success_message ?? '' }}';
            var session_error_message = '{{ $session_error_message ?? '' }}';
            if (session_success_message) {
                toastr.success(session_success_message);
            }

            if (session_error_message) {
                toastr.danger(session_error_message);
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var enquiry_validator = $("#enquiry-form").validate({
                ignore: "",
                rules: {
                    'name': 'required',
                    'email': 'required',
                    'country': 'required',
                    'phone': 'required',
                    'message': 'required',
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.closest('.flex'));
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $(form).find('#redirect-url').val('{!! route('front.trips.show', $trip) !!}');
                    if (grecaptcha.getResponse(0)) {
                        var btn = $(form).find('button[type=submit]').attr('disabled', true).html(
                            'Sending...');
                        setTimeout(() => {
                            form.submit();
                        }, 500);
                    } else {
                        grecaptcha.reset(enquiry_captcha);
                        grecaptcha.execute(enquiry_captcha);
                    }
                },
            });
        });

        function onSubmitEnquiry(token) {
            $("#enquiry-form").submit();
            return true;
        }

        let enquiry_captcha;
        var CaptchaCallback = function() {
            enquiry_captcha = grecaptcha.render('inquiry-g-recaptcha', {
                'sitekey': '{!! config('constants.recaptcha.sitekey') !!}'
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
            let groupDepartureStatus = true;
            let privateDepartureList = [];
            let groupDepartureList = [];

            $(".select-date-departure").on('click', function(event) {
                const dateStr = $(this).data('date');
                filterDepartureByMonth(dateStr);
                removeDateActive();
                $(this).addClass('departure-date-active bg-primary text-white');
                $(this).removeClass('hover:text-primary bg-white');
            });

            function removeDateActive() {
                var parentDiv = document.getElementById('all-dates-block');
                if (parentDiv) {
                    var childDivs = parentDiv.getElementsByTagName('button');
                    for (var i = 0; i < childDivs.length; i++) {
                        if (childDivs[i].classList.contains('departure-date-active')) {
                            childDivs[i].classList.remove('departure-date-active', 'bg-primary', 'text-white');
                            childDivs[i].classList.add('hover:text-primary', 'bg-white');
                        }
                    }
                }
            }
            const trip_departures = @json($trip_departures ?? []);
            const trip = @json($trip);

            $("#group-departure").on('click', function(event) {
                document.getElementById("private-departure").classList.remove('text-primary',
                    'border-primary');
                document.getElementById("group-departure").classList.add('text-primary', 'border-primary');
                showGroupDeparture();
                groupDepartureStatus = true;
            });

            $("#private-departure").on('click', function(event) {
                document.getElementById("group-departure").classList.remove('text-primary',
                    'border-primary');
                document.getElementById("private-departure").classList.add('text-primary',
                    'border-primary');
                const currentDate = new Date();
                const currentMonthIndex = currentDate.getMonth();
                const currentMonth = currentMonthIndex + 1;
                const currentYear = currentDate.getFullYear();
                showPrivateDeparture(currentMonth, currentYear);
                groupDepartureStatus = false;
            });

            function showGroupDeparture() {
                $('#show-more-departure-button').hide();
                let html = "";
                let filteredDepartures = trip_departures;
                if (filteredDepartures.length > 0) {
                    groupDepartureList = trip_departures;
                    $("#departure-filter-block").html(html);
                    displayMoreGroupDepartureItems(groupDepartureList, 10);
                } else {
                    html = "No departures found.";
                    $("#departure-filter-block").html(html);
                }
            }

            function showPrivateDeparture(month = 1, year) {
                const trip_days = {{ $trip->duration }};
                const dateList = [];
                let next = true;
                const currentDate = new Date();
                const currentMonthIndex = currentDate.getMonth();
                const currentMonth = currentMonthIndex + 1;
                let currentDay = '01';
                if (month == currentMonth) {
                    currentDay = currentDate.getDate().toString().padStart(2, '0');
                }
                let startDate = convertToTimestamp(`${year}-0${month}-${currentDay}`);
                while (next) {
                    const generateDate = getDateRangeForGap(startDate, parseInt(trip_days));
                    dateList.push(generateDate);
                    startDate = getNextDayTimestamp(generateDate.start);
                    if (!isTimestampInMonth(startDate, month)) {
                        next = false;
                    }
                }
                privateDepartureList = dateList;
                let html = "";
                $("#departure-filter-block").html(html);
                displayMorePrivateDepartureItems(privateDepartureList, 10);
            }

            function getAllPrivateDeparture(month = 1, year) {
                const trip_days = {!! json_encode($trip->duration) !!};
                const dateList = [];
                let next = true;
                const currentDate = new Date();
                const currentMonthIndex = currentDate.getMonth();
                const currentMonth = currentMonthIndex + 1;
                let currentDay = '01';
                if (month == currentMonth) {
                    currentDay = currentDate.getDate().toString().padStart(2, '0');
                }
                let startDate = convertToTimestamp(`${year}-0${month}-${currentDay}`);
                while (next) {
                    const generateDate = getDateRangeForGap(startDate, parseInt(trip_days));
                    dateList.push(generateDate);
                    startDate = getNextDayTimestamp(generateDate.start);
                    if (!isTimestampInMonth(startDate, month)) {
                        next = false;
                    }
                }
                return dateList;
            }

            function displayMoreGroupDepartureItems(items, limit) {
                const itemsContainer = document.getElementById('departure-filter-block');

                for (let i = 0; i < limit && i < items.length; i++) {
                    const item = items[i];

                    function formatDate(date) {
                        return new Date(date).toLocaleDateString('en-US', {
                            month: 'short',
                            day: '2-digit',
                            year: 'numeric'
                        });
                    }

                    let urlroute =
                        `{{ route('home') . '/trips/TRIP_SLUG/departure-booking/DEPARTURE_ID' }}`;
                    urlroute = urlroute.replace('TRIP_SLUG', trip.slug);
                    urlroute = urlroute.replace('DEPARTURE_ID', item.id);
                    listItem = `<div class="relative grid grid-cols-2 gap-4 px-4 py-3 bg-white border-2 border-gray-100 rounded-lg lg:px-10 lg:grid-cols-5 hover:border-primary">
                            <div class="absolute top-0 px-1 text-xs text-gray-400 bg-white border border-gray-100 rounded-full left-4" style="translate: 0 -50%;">Group</div>
                            <div class="absolute top-0 right-0 w-10 h-10 overflow-hidden rounded-sm">
                                <div class="w-16 px-1 pt-4 text-xs text-center text-white bg-red-600" style="rotate: 45deg; margin-top: -8px">${Math.floor((trip.cost - trip.offer_price)/trip.cost * 100)}%</div>
                            </div>
                            <div>
                                <div class="font-bold">${formatDate(item.from_date)}</div>
                                <div class="text-sm text-gray-500">From ${trip.starting_point}</div>
                            </div>
                            <div>
                                <div class="font-bold">${formatDate(item.to_date)}</div>
                                <div class="text-sm text-gray-500">To ${trip.ending_point}</div>
                            </div>
                            <div>
                                <div class="font-semibold">${item.seats}</div>
                                <div class="text-sm text-gray-500">seats left</div>
                            </div>
                            <div>
                                <div class="text-sm font-semibold">From <span class="text-red-500"><s>US$ ${numberFormatFromString(trip.cost)}</s></span></div>
                                <div class="font-semibold">US$ US$ ${numberFormatFromString(item.price)}</div>
                                <div class="text-sm text-green-600">Saving US$ ${numberFormatFromString(trip.cost - item.price)}</div>
                            </div>
                            <div class="flex items-center">
                                <a href="${urlroute}" class="px-3 py-2 text-sm border rounded-sm border-primary text-primary hover:bg-primary hover:text-white">Book Now</a>
                            </div>
                        </div>`;
                    $(itemsContainer).append(listItem);
                }


                if (items.length > limit) {
                    groupDepartureList = groupDepartureList.slice(limit);
                    $('#show-more-departure-button').show();
                } else {
                    $('#show-more-departure-button').hide();
                }
            }

            function displayMorePrivateDepartureItems(items, limit) {
                const itemsContainer = document.getElementById('departure-filter-block');

                for (let i = 0; i < limit && i < items.length; i++) {
                    const item = items[i];
                    let urlroute =
                        `{{ route('front.trips.booking', ['trip' => 'TRIP_SLUG', 'date' => 'DEPARTURE_DATE']) }}`;
                    urlroute = urlroute.replace('TRIP_SLUG', trip.slug);
                    urlroute = urlroute.replace('DEPARTURE_DATE', item.start);
                    const listItem = `<div class="relative grid grid-cols-2 gap-4 px-4 py-3 bg-white border-2 border-gray-100 rounded-lg lg:px-10 lg:grid-cols-5 hover:border-primary">
                            <div class="absolute top-0 px-1 text-xs text-gray-400 bg-white border border-gray-100 rounded-full left-4" style="translate: 0 -50%;">Private</div>
                            <div class="absolute top-0 right-0 w-10 h-10 overflow-hidden rounded-sm">
                                <div class="w-16 px-1 pt-4 text-xs text-center text-white bg-red-600" style="rotate: 45deg; margin-top: -8px">-${Math.floor((trip.cost - trip.offer_price)/trip.cost * 100)}%</div>
                            </div>
                            <div>
                                <div class="font-bold">${convertToFormattedDate(item.start)}</div>
                                <div class="text-sm text-gray-400">From ${trip.starting_point}</div>
                            </div>
                            <div>
                                <div class="font-bold">${convertToFormattedDate(item.end)}</div>
                                <div class="text-sm text-gray-400">To ${trip.ending_point}</div>
                            </div>
                            <div>
                            </div>
                            <div>
                                <div class="text-sm font-semibold">From <span class="text-red-500"><s>US$ ${numberFormatFromString((trip.offer_price != "") ? trip.cost : '')}</s></span></div>
                                <div class="font-semibold">US$ ${numberFormatFromString((trip.offer_price != "") ? trip.offer_price : trip.cost)}</div>
                                <div class="text-sm text-green-600">${trip.offer_price != "" ? `Saving US$ ${numberFormatFromString(trip.cost - trip.offer_price)}` : ''}</div>
                            </div>
                            <div class="flex items-center">
                                <a href="${urlroute}" class="px-3 py-2 text-sm border rounded-sm border-primary text-primary hover:bg-primary hover:text-white">Book Now</a>
                            </div>
                        </div>`;
                    $(itemsContainer).append(listItem);
                }

                if (items.length > limit) {
                    privateDepartureList = privateDepartureList.slice(limit);
                    $('#show-more-departure-button').show();
                } else {
                    $('#show-more-departure-button').hide();
                }
            }

            $("#show-more-departure-button").on('click', function(event) {
                if (groupDepartureStatus) {
                    displayMoreGroupDepartureItems(groupDepartureList, 10);
                } else {
                    displayMorePrivateDepartureItems(privateDepartureList,
                        10);
                }
            });

            $("#private-departure").click();

            function isTimestampInMonth(timestamp, targetMonth) {
                const date = new Date(timestamp * 1000);
                const month = date.getMonth() + 1;

                return month === targetMonth;
            }

            function getNextDayTimestamp(timestamp) {
                const currentDate = new Date(timestamp * 1000);
                const nextDate = new Date(currentDate);
                nextDate.setDate(currentDate.getDate() + 1);

                const nextDayTimestamp = Math.floor(nextDate.getTime() / 1000);
                return nextDayTimestamp;
            }

            function convertToTimestamp(dateString) {
                const timestamp = Math.floor(Date.parse(dateString) / 1000);
                return timestamp;
            }

            function convertToFormattedDate(timestamp) {

                const date = new Date(timestamp * 1000);
                const options = {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                };
                return date.toLocaleDateString('en-US', options);
            }

            function getDateRangeForGap(startTimestamp, gap) {
                const startDateObj = new Date(startTimestamp * 1000);
                const endDateObj = new Date(startDateObj.getFullYear(), startDateObj.getMonth(), startDateObj
                    .getDate() + gap - 1);

                const startTimestampResult = Math.floor(startDateObj.getTime() / 1000);
                const endTimestampResult = Math.floor(endDateObj.getTime() / 1000);

                return {
                    start: startTimestampResult,
                    end: endTimestampResult
                };
            }

            $("#all-departure-filter").on('click', function(event) {
                handleFilterDpartureClick();
                $(this).addClass('departure-date-active');
            });

            function handleFilterDpartureClick() {
                filterDepartureByMonth("all");
                removeDateActive();
            }

            handleFilterDpartureClick();

            function filterDepartureByMonth(dateStr) {
                let html = "";

                let filteredDepartures = trip_departures;
                if (groupDepartureStatus) {
                    if (dateStr !== "all") {
                        const startMonth = new Date(dateStr * 1000).getMonth() +
                            1;
                        filteredDepartures = trip_departures.filter(departure => {
                            const departureMonth = new Date(departure.from_date.replace(/-/g, '/'))
                                .getMonth() +
                                1;
                            return departureMonth === startMonth
                        });
                    }
                    if (filteredDepartures.length > 0) {
                        $.each(filteredDepartures, (i, departure) => {
                            let urlroute =
                                `{{ route('home') . '/trips/TRIP_SLUG/departure-booking/{DEPARTURE_ID}' }}`;
                            urlroute = urlroute.replace('TRIP_SLUG', trip.slug);
                            urlroute = urlroute.replace('DEPARTURE_ID', departure.id);
                            html += `<div class="relative grid grid-cols-2 gap-4 px-4 py-3 bg-white border-2 border-gray-100 rounded-lg lg:px-10 lg:grid-cols-5 hover:border-primary">
                                <div class="absolute top-0 px-1 text-xs text-gray-400 bg-white border border-gray-100 rounded-full left-4" style="translate: 0 -50%;">Group</div>
                                <div class="absolute top-0 right-0 w-10 h-10 overflow-hidden rounded-sm">
                                    <div class="w-16 px-1 pt-4 text-xs text-center text-white bg-red-600" style="rotate: 45deg; margin-top: -8px">-10%</div>
                                </div>
                                <div>
                                    <div class="font-bold">${formatDate(departure.from_date)}</div>
                                    <div class="text-sm text-gray-400">From ${trip.starting_point}</div>
                                </div>
                                <div>
                                    <div class="font-bold">${formatDate(departure.to_date)}</div>
                                    <div class="text-sm text-gray-400">To ${trip.ending_point}</div>
                                </div>
                                <div>
                                    <div class="font-bold">${departure.seats}</div>
                                    <div class="text-sm text-gray-400">people booked</div>
                                </div>
                                <div>
                                    <div class="font-bold">From <span class="text-red"><s>US $ ${numberFormatFromString(trip.cost)}</s></span></div>
                                    <div class="text-lg font-bold">US$ ${numberFormatFromString(departure.price)}</div>
                                    <div class="text-sm"><span class="text-sm text-green-600">Saving </span>US$ ${numberFormatFromString(trip.cost - departure.price)}</div>
                                </div>
                                <div class="flex items-center">
                                    <a href="${urlroute}" class="px-3 py-2 text-sm border rounded-sm border-primary text-primary hover:bg-primary hover:text-white">Book Now</a>
                                </div>
                            </div>`;
                        })
                    } else {
                        html = "No departures found.";
                    }
                    $("#departure-filter-block").html(html);
                } else {
                    if (dateStr !== "all") {
                        const startMonth = new Date(dateStr * 1000).getMonth() + 1;
                        const currentYear = new Date(dateStr * 1000).getFullYear();
                        showPrivateDeparture(startMonth, currentYear);
                    } else {
                        privateDepartureList = [];
                        const currentDate = new Date();
                        let currentMonth = currentDate.getMonth();
                        let currentYear = currentDate.getFullYear();
                        currentMonth = currentMonth + 1;
                        for (let i = 0; i < 24; i++) {
                            let year = currentYear;
                            if (currentMonth > 12) {
                                currentMonth -= 12;
                                year++;
                                currentYear = year;
                            }
                            let dateList = getAllPrivateDeparture(currentMonth, currentYear);
                            privateDepartureList = privateDepartureList.concat(dateList);
                            currentMonth = currentMonth + 1;
                        }
                        let html = "";
                        $("#departure-filter-block").html(html);
                        displayMorePrivateDepartureItems(privateDepartureList, 10);
                    }
                }
            }

            function formatDate(date) {
                return new Date(date.replace(/-/g, '/')).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            function numberFormatFromString(price) {
                return parseInt(price, 10).toLocaleString();
            }
        });
    </script>
@endpush
