@props(['image_url' => asset('assets/front/img/hero.jpg'), 'image_alt' => '', 'title', 'breadcrumbs' => [], 'size' => 'sm'])
<section class="relative">
    <img src="{{ $image_url }}" alt=" {{ $image_alt }}" class="object-cover w-full @if ($size === 'lg') h-[36rem] @else h-96 @endif">
    <div class="absolute inset-0 flex items-end">
        <div class="w-full bg-linear-to-t from-black/60 to-black/0 pt-10 @if ($size === 'lg') pb-24 @else pb-10 @endif">
            <div class="container text-white">
                <h1 class="mb-4 text-3xl font-semibold text-center lg:text-5xl font-display">{{ $title }}</h1>
                <div>
                    <nav aria-label="breadcrumb" class="flex justify-center">
                        <ol>
                            <li class="inline"><a href="{{ url('/') }}">Home</a></li>
                            <span class="inline-block mx-2">/</span>
                            @foreach ($breadcrumbs as $item)
                                @if (key_exists('url', $item))
                                    <li class="inline"><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
                                @else
                                    <li class="inline">{{ $item['name'] }}</li>
                                @endif
                                <span class="inline-block mx-2">/</span>
                            @endforeach
                            <li class="inline text-white/80" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
