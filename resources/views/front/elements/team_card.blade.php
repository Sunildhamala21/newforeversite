<div class="grid gap-4 p-4 bg-white border-2 border-gray-100 lg:grid-cols-3 lg:gap-10 rounded-xl lg:p-10">
    <div class="shrink-0 mb-4">
        <img src="{{ $item->imageUrl }}"
             alt=""
             class="w-full mx-auto mb-4 rounded-lg max-w-48">
        <h2 class="mb-1 text-xl text-center font-display text-primary">{{ $item->name }}</h2>
        <div class="mb-2 text-center text-gray">{{ $item->position }}</div>
    </div>
    <div class="relative col-span-2"
         x-data="{ expanded: false, showControls: true }"
         x-init="if ($refs.description.scrollHeight < 427) {
             expanded = true;
             showControls = false
         }">
        <div class="mb-4 prose"
             x-show="expanded"
             :class="{ 'pb-20': showControls }"
             x-collapse.min.427px
             x-ref="description">
            {!! $item->description !!}
        </div>
        <div class="absolute bottom-0 flex justify-center w-full py-4"
             style="background: linear-gradient(to top, rgba(255,255,255,1), rgba(255,255,255,0));"
             x-show="showControls">
            <button class="px-4 py-2 text-xs bg-white border border-gray-200 rounded-full hover:bg-light"
                    x-on:click="expanded=!expanded"
                    x-text="expanded?'Show less':'Show more'">Show more</button>
        </div>
    </div>
</div>
