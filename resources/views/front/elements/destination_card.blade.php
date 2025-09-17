<div class="destination">
    <a href="{{ route('front.destinations.show', $destination) }}">
        <div class="destination__img">
            <img src="{{ $destination->mediumImageUrl }}" class="block w-full"
                alt="{{ $destination->image_alt ?? $destination->name }}" width="600" height="450">
        </div>
        <div class="px-4 py-2 flex justify-between">
            <h3 class="font-bold">{{ $destination->name }}</h3>
            <div class="text-sm text-gray-500">{{ $destination->trips->count() }} trips</div>
        </div>
    </a>
</div>
