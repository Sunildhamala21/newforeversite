@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tiny-slider@2.9.3/dist/tiny-slider.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/front-search-slider.css') }}">
@endpush
@extends('layouts.front_inner')
@section('title', $seo->meta_title ?? $destination->name)
@section('meta_description'){!! $seo->meta_description ?? '' !!}@stop
@section('meta_keywords'){!! $seo->meta_keywords ?? '' !!}@stop
@section('meta_og_url'){!! $seo->canonical_url ?? '' !!}@stop
@section('meta_og_description'){!! $seo->meta_description ?? '' !!}@stop
@section('meta_og_image'){!! $seo->socialImageUrl ?? '' !!}@stop
@section('content')

    <x-hero :title="$destination->name" :image_url="$destination->largeImageUrl" :breadcrumbs="[['url' => route('front.destinations.index'), 'name' => 'Destinations']]" />

    <section class="py-10 sm:py-20">
        <div class="container">
            <div class="mx-auto prose">
                <x-collapsible-content :content="$destination->description" />
            </div>
        </div>
    </section>

    {{-- Travel Guide --}}
    <div class="relative py-10 border border-primary/20 sm:py-20">
        <div class="container">
            <div class="grid gap-4 sm:gap-10 lg:grid-cols-2">
                <div class="prose">
                    <h2>
                        <div class="mb-2 text-2xl font-handwriting text-primary">The Definitive</div>
                        <div class="text-3xl font-bold text-gray-600 uppercase font-display lg:text-5xl">
                            {{ $destination->name }} Travel Guide</div>
                    </h2>
                    <p>{!! $destination->tour_guide_description !!}</p>
                </div>
                <div>
                    @if (!empty($destination->tour_guide_image_name))
                        <img src="{{ $destination->tour_guide_image_url }}"">
                    @else
                        <img src="{{ asset('assets/front/img/nepal.webp') }}"">
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-filter-trips :destination="$destination" />

    @include('front.elements.plan_trip')

@endsection
