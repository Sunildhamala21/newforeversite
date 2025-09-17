@extends('layouts.front_inner')
@section('meta_og_title', 'Blog Categories')
@section('content')

    <x-hero title="Blog Categories" />

    <section class="py-20 news">
        <div class="container">
            <div class="grid gap-4 lg:grid-cols-3 lg:gap-10">
                @forelse ($blogs as $blog)
                    <a href="{{ route('front.blogCategories.show', $blog) }}">
                        <div class="relative">
                            <img src="{{ $blog->imageUrl }}"
                                 alt=""
                                 class="rounded">
                            <div class="absolute bottom-0 left-0 p-2 text-white bg-primary">{{ $blog->formattedDate }}</div>
                        </div>
                        <div class="mt-6 prose">
                            <h2>{{ $blog->name }}</h2>
                            <p>{{ truncate(html_entity_decode(strip_tags($blog->description))) }}</p>
                        </div>
                    </a>
                @empty
                @endforelse
            </div>
            <div class="mt-6">{{ $blogs->links('pagination.default') }}</div>
        </div>
    </section>
@endsection
