@extends('layouts.front_inner')
@section('title', $seo->meta_title ?? $region->name)
@push('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/front-search-slider.css') }}">
@endpush
@section('meta_og_title'){!! $seo->meta_title ?? '' !!}@stop
@section('meta_description'){!! $seo->meta_description ?? '' !!}@stop
@section('meta_keywords'){!! $seo->meta_keywords ?? '' !!}@stop
@section('meta_og_url'){!! $seo->canonical_url ?? '' !!}@stop
@section('meta_og_description'){!! $seo->meta_description ?? '' !!}@stop
@section('meta_og_image'){!! $seo->socialImageUrl ?? '' !!}@stop
@section('content')

    <x-hero :title="$region->name" :image_url="$region->largeImageUrl" />

    <section>
        <div class="container py-10 sm:py-20">
            <div class="mx-auto prose">
                <x-collapsible-content :content="$region->description" />
            </div>
        </div>
    </section>
    <x-filter-trips :region="$region" />
@endsection
