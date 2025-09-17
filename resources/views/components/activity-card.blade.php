@props(['activity', 'link'])

<a href="{{ $link }}" class="flex flex-col flex-shrink-0 overflow-hidden rounded-lg w-58 h-96">
    <div class="relative flex-grow">
        <img src="{{ $activity->mediumImageUrl }}" class="object-cover w-full h-full">
        <div class="absolute bottom-0 left-0 right-0 h-10 bg-gradient-to-t from-dark to-dark/0">
        </div>
    </div>
    <div class="px-4 pt-2 pb-4 bg-dark">
        <div class="text-lg font-display uppercase">{{ $activity['name'] }}</div>
    </div>
</a>
