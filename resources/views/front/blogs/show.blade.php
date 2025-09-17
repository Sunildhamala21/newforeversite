@extends('layouts.front_inner')
@section('meta_og_title'){!! $blog->seo->meta_title ?? '' !!}@stop
@section('meta_description'){!! $blog->seo->meta_description ?? '' !!}@stop
@section('meta_keywords'){!! $blog->seo->meta_keywords ?? '' !!}@stop
@section('meta_og_url'){!! $blog->seo->canonical_url ?? '' !!}@stop
@section('meta_og_description'){!! $blog->seo->meta_description ?? '' !!}@stop
@section('meta_og_image'){!! $blog->seo->socialImageUrl ?? '' !!}@stop
@section('content')
    @php 
        $homePageSeo = Setting::get('homePageSeo');
        $ogImage = is_array($homePageSeo) && isset($homePageSeo['og_image']) ? $homePageSeo['og_image'] : null;

        $blogSchema = Spatie\SchemaOrg\Schema::BlogPosting()
            ->headline($blog->name)
            ->image(
                Spatie\SchemaOrg\Schema::ImageObject()
                    ->url($blog->imageUrl ?? '')
                    ->width(800)
                    ->height(650),
            )
            ->url(route('front.blogs.show', $blog->slug))
            ->datePublished($blog->created_at)
            ->dateModified($blog->updated_at)
            ->description($blog->seo?->meta_description ?? strip_tags($blog->description))
            ->publisher(
                Spatie\SchemaOrg\Schema::Organization()
                    ->name(Setting::get('site_name') ?? '')
                    ->url(route('home'))
                    ->logo(
                        Spatie\SchemaOrg\Schema::ImageObject()
                        ->url(Setting::getSiteSettingImage($ogImage))
                        ->width(800)
                            ->height(650),
                    ),
            );
        if (isset($author)) {
            $blogSchema->author(
                Spatie\SchemaOrg\Schema::Person()
                    ->name($author->name ?? '')
                    ->url(route('front.teams.show', $author->slug)),
            );
        }
    @endphp


    @push('schema')
        {!! $blogSchema->toScript() !!}
    @endpush

    <x-hero :title="$blog->name" :image_url="$blog->largeImageUrl" :breadcrumbs="[['url' => route('front.blogs.index'), 'name' => 'Blog']]" />

    <section class="container grid gap-10 py-20 @if ($contents) lg:grid-cols-3 @endif">
        @if ($contents)
            <div>
                <div class="sticky p-6 rounded-lg top-32 bg-light">
                    <h2 class="mb-4 text-lg font-semibold text-primary font-display">{{ $blog->name }}</h2>
                    <div class="mx-auto prose prose-a:no-underline">
                        {!! $contents !!}
                    </div>
                </div>
            </div>
        @endif
        <div @if ($contents) class="lg:col-span-2" @endif>
            <div class="mx-auto prose prose-headings:text-primary">
                {!! $body !!}
            </div>
        </div>
        <div class="space-x-2 text-xs">
            @foreach ([] as $tag)
                {{-- @foreach ($blog->tags as $tag) --}}
                <a class="inline-flex px-1 py-0.5 rounded bg-primary/10"
                    href="{{ route('front.blogs.tags', $tag->slug) }}">{{ $tag->name }}</a>
            @endforeach
        </div>
    </section>

    <!-- similar blogs -->
    @if (isset($blog->similar_blogs) && !empty($blog->similar_blogs))
        <section class="py-10 bg-gray-100 lg:py-20">
            <div class="container">
                <h2 class="relative pt-10 pb-10 pr-10 text-3xl font-bold text-gray-600 uppercase lg:text-4xl font-display">
                    Latest Travel Blogs</h2>
                <div class="absolute right-0 w-6 h-1 rounded-sm top-1/2 bg-accent"></div>
                <div class="grid gap-4 lg:grid-cols-3 lg:gap-10">
                    @foreach ($blog->similar_blogs as $s_blog)
                        @include('front.elements.blog_card', ['blog' => $s_blog])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
