@if ($paginator->hasPages())
    <nav>
        <ul class="flex flex-wrap items-center justify-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="p-2 disabled text-gray" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">Previous Page</span>
                </li>
            @else
                <li class="p-2">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Previous Page</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="p-2 disabled text-gray" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="flex items-center justify-center w-8 h-8 p-2 text-white rounded-full bg-primary" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li class="p-2"><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="p-2">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next Page</a>
                </li>
            @else
                <li class="p-2 disabled text-gray" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">Next Page</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
