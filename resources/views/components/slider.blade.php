<div class="embla banner-slider relative">
    <div class="px-4 md:px-8 2xl:px-[calc(((100vw-1500px)/2)+2rem)] embla__viewport">
        <div class="embla__container scroll-px-20">
            {{ $slot }}
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
