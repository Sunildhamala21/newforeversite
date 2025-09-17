@extends('layouts.front_inner')
@section('title', $seo->meta_title ?? $activity->name)
@section('meta_description'){!! $seo->meta_description ?? '' !!}@stop
@section('meta_keywords'){!! $seo->meta_keywords ?? '' !!}@stop
@section('meta_og_url'){!! $seo->canonical_url ?? '' !!}@stop
@section('meta_og_description'){!! $seo->meta_description ?? '' !!}@stop
@section('meta_og_image'){!! $seo->socialImageUrl ?? '' !!}@stop
@section('content')

    <x-hero :title="$activity->name" :image_url="$activity->largeImageUrl" :breadcrumbs="[['url' => route('front.activities.index'), 'name' => 'Activities']]" />

    <section class="py-10 sm:py-20">
        <div class="container">
            <div class="mx-auto prose">
                <x-collapsible-content :content="$activity->description" />
            </div>
        </div>
    </section>

    <x-filter-trips :activity="$activity" />

    @include('front.elements.plan_trip')

@endsection
