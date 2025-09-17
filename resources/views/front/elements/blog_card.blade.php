<a href="{{ route('front.blogs.show', $blog->slug) }}">
    <div class="article">
        <div class="image">
            <img src="{{ $blog->mediumImageUrl }}" width="480" height="360" alt="{{ $blog->name }}" loading="lazy"
                class="object-cover aspect-4/3">
        </div>
        <div class="content">
            <h2 class="mb-2 font-semibold lg:text-lg">{{ $blog->name }}</h2>
            <div class="flex items-center mb-2 text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ formatDate($blog->blog_date) }}
            </div>
            <p class="text-sm">
                {{ truncate(strip_tags($blog->toc)) }}
            </p>
            <div class="space-x-2 text-xs">
                @foreach ([] as $tag)
                    {{-- @foreach ($blog->tags as $tag) --}}
                    <span class="inline-flex px-1 py-0.5 rounded bg-primary/10">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
</a>
