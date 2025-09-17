@extends('layouts.front_inner')
@section('title', 'Blog')
@section('content')

    <x-hero :title="isset($tag) ? 'Blogs tagged \'' . $tag . '\'' : 'Blog'" />

    <section class="py-20">
        <div class="container">
            @if (isset($categories) && !empty($categories))
                <section class="my-10">
                    <h2 class="relative pr-10 mb-4 text-2xl font-bold text-gray-600 uppercase font-display">Blog Categories
                    </h2>
                    @foreach ($categories->sortByDesc(fn($category) => $category->blogs->count()) as $category)
                        <a href="{{ route('front.blogCategories.show', $category) }}"
                            class="inline-flex items-center gap-1 px-4 py-2 mt-2 mr-2 text-sm border-2 border-gray-200 rounded-lg text-primary hover:bg-light hover:border-primary">
                            {{ $category->name }} ( {{ $category->blogs->count() }} )
                        </a>
                    @endforeach
                </section>
            @endif

            <div class="grid gap-4 my-10 lg:grid-cols-3 lg:gap-10">
                @forelse ($blogs as $blog)
                    @include('front.elements.blog_card')
                @empty
                @endforelse
            </div>
            {{ $blogs->links('pagination.default') }}
        </div>
    </section>
@endsection
