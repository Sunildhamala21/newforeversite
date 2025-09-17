<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center gap-1 md:gap-2 ">
        <li class="inline-flex items-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm text-gray-700 hover:text-accent">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                </svg>
                Home
            </a>
        </li>
        @foreach ($navs as $nav)
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="{{ $nav['link'] }}" class="ml-1 text-sm text-gray-700 hover:text-accent md:ml-2 ">{{ $nav['title'] }}</a>
                </div>
            </li>
        @endforeach
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <span class="ml-1 text-sm text-gray-500 md:ml-2">{{ $current }}</span>
            </div>
        </li>
    </ol>
</nav>
