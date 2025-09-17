<div class="embla reviews-slider relative mt-4">
    <div class="embla__viewport">
        <div class="embla__container">
            @foreach ($reviews as $review)
                <a href="{{ $review['url'] }}"
                    class="p-6 bg-white rounded-lg flex flex-col items-start group embla__slide flex-[0_0_100%] sm:flex-[0_0_calc(50%-12px)] md:flex-[0_0_calc((100%-24px)/3)]">
                    <img src="{{ $review['rating_image_url'] }}" alt="" class="h-4 -ml-2">
                    <h3 class="mt-2 text-xl font-display  flex-grow">{{ $review['title'] }}</h3>
                    <div class="prose prose-sm mt-2 review">
                        <p class="h-40 overflow-scroll pr-2">{{ $review['text'] }}</p>
                    </div>
                    <div class="flex justify-between items-center w-full">
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ $review['user']['avatar'] }}" alt="{{ $review['user']['username'] }}"
                                    loading="lazy" class="rounded-full">
                                <div>
                                    <div class="text-gray-500 text-sm font-semibold">
                                        {{ '@' . $review['user']['username'] }}
                                    </div>
                                    <div class="text-gray-500 text-sm">
                                        {{ Carbon\Carbon::parse($review['published_date'])->toFormattedDateString() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-icons.tripadvisor class="size-10 opacity-0 group-hover:opacity-100 transition-opacity" />
                    </div>
                </a>
            @endforeach
        </div>
        <div class="absolute left-0 right-0 flex flex-wrap justify-center gap-4 mx-auto mt-4 dots"></div>
        <div class="absolute left-0 z-10 -translate-y-1/2 top-1/2">
            <button class="p-2 bg-black/50 button-prev disabled:opacity-0">
                <svg class="text-white size-6" xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M14.414 5.586c-.78-.781-2.048-.781-2.828 0l-6.415 6.414 6.415 6.414c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828l-3.585-3.586 3.585-3.586c.781-.781.781-2.047 0-2.828z">
                    </path>
                </svg>
            </button>
        </div>
        <div class="absolute right-0 z-10 -translate-y-1/2 top-1/2">
            <button class="p-2 bg-black/50 button-next disabled:opacity-0">
                <svg class="text-white size-6" xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M8.586 5.586c-.781.781-.781 2.047 0 2.828l3.585 3.586-3.585 3.586c-.781.781-.781 2.047 0 2.828.39.391.902.586 1.414.586s1.024-.195 1.414-.586l6.415-6.414-6.415-6.414c-.78-.781-2.048-.781-2.828 0z">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</div>
