<a href="{{ route('front.trips.show', $trip) }}" class="block mb-2">
    <div class="h-full px-2 py-4 text-white rounded-lg"
        style="background: linear-gradient(to right, rgba(0,0,0,.3), rgba(0,0,0,.1)), center / cover url('{{ $trip->thumb_imageUrl }}')">
        <h3 class="text-xl font-display">{{ $trip->name }}</h3>
        <div class="mb-4 days"><?= $trip->duration ?> days</div>
        <div class="price"><span class="text-xs">from</span> <br><b>USD {{ number_format($trip->cost) }}</b></div>
    </div>
</a>
