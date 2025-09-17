@props(['height' => 600, 'content'])

<div {{ $attributes->class(['relative']) }} x-data="{ expanded: false, showButton: false }" x-init="$nextTick(() => {
    if ($refs.content.scrollHeight > {{ $height }}) {
        showButton = true;
    } else {
        $refs.content.style.height = 'auto';
    }
})">
    <div x-ref="content" x-show="expanded" x-collapse.min.{{ $height }}px>
        <div class="prose" x-bind:class="{ 'pb-20': showButton }">{!! $content !!}
        </div>
    </div>
    <template x-if="showButton">
        <div
            class="absolute bottom-0 flex justify-center w-full py-4 bg-gradient-to-t from-white from-20% to-transparent">
            <button class="px-4 py-2 text-xs rounded-full border-white/50 border-3 bg-primary-light"
                x-on:click="expanded=!expanded" x-text="expanded ? 'Show less' : 'Show more'">
                Show more
            </button>
        </div>
    </template>
</div>
