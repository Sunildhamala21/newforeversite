@extends('layouts.front_inner')
@section('meta_og_title'){!! $blog->seo->meta_title ?? '' !!}@stop
@section('meta_description'){!! $blog->seo->meta_description ?? '' !!}@stop
@section('meta_keywords'){!! $blog->seo->meta_keywords ?? '' !!}@stop
@section('meta_og_url'){!! $blog->seo->canonical_url ?? '' !!}@stop
@section('meta_og_description'){!! $blog->seo->meta_description ?? '' !!}@stop
@section('meta_og_image'){!! $blog->seo->socialImageUrl ?? '' !!}@stop
@section('created_at'){!! $blog->seo->created_at ?? '' !!}@stop

@section('content')

    <x-hero :title="$blogCategory->name" :image_url="$blogCategory->imageUrl" :breadcrumbs="[
        ['name' => 'Blog', 'url' => route('front.blogs.index')],
        ['name' => 'Categories', 'url' => route('front.blogCategories.index')],
    ]" />

    <section class="my-20">
        <div class="container grid items-start gap-10 md:grid-cols-3">
            <div class="md:col-span-2">

                <x-collapsible-content :content="$blogCategory->description" />
            </div>

            <div class="px-4 py-3 ml-auto text-white rounded-md bg-primary max-w-80">
                <div>
                    <h5 class="mb-2 text-lg font-semibold">Talk to our expert</h5>
                    <a href="tel:{{ Setting::get('mobile1') }}" class="flex mb-2 sm:justify-start">
                        <svg class="w-6 h-6 mr-2">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#phone" />
                        </svg>
                        <span class="mr-2">{{ Setting::get('mobile1') }}</span>
                    </a>
                    <a href="mailto:{{ Setting::get('email') }}" class="flex mb-0 sm:justify-start">
                        <svg class="w-6 h-6 mr-2">
                            <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#mail" />
                        </svg>
                        <span class="mr-2">{{ Setting::get('email') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- similar blogs -->
    <section class="my-20">
        <div class="container">
            @if ($blogs->count())
                <div class="grid gap-4 mb-10 lg:grid-cols-3 lg:gap-10">
                    @foreach ($blogs as $blog)
                        @include('front.elements.blog_card')
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $blogs->links('pagination.default') }}
                </div>
            @else
                <p>No blogs found in this category.</p>
            @endif
        </div>
    </section>
@endsection
