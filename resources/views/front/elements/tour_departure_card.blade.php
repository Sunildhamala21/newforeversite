<div class="p-2 rounded-lg bg-gradient lg:p-4">
    <h2 class="mb-4 text-2xl uppercase font-display text-primary">
        <a href="{{ route('front.trips.show', $departure->trip) }}">
            <?= $departure->trip->name ?>
        </a>
    </h2>
    <div class="text-sm">
        <div class="flex mb-2 aic">
            <svg class="w-4 h-4 mr-1 text-primary">
                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#calendar" />
            </svg>
            {{ formatDate($departure->from_date) }} <br> {{ formatDate($departure->to_date) }}
        </div>
        <div class="flex mb-2 aic">
            <svg class="w-4 h-4 mr-1 text-primary">
                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#tag" />
            </svg>
            <div>
                <small class="text-gray"><s>USD {{ number_format($departure->trip->cost) }}</s></small><br>
                <span class="text-green">USD <b>{{ number_format($departure->price) }}</b></span>
            </div>
        </div>
        <div class="flex mb-8">
            <svg class="w-4 h-4 mr-1 text-primary">
                <use xlink:href="{{ asset('assets/front/img/sprite.svg') }}#users" />
            </svg>
            {{ $departure->seats }} seats left
        </div>
    </div>
    <div><a href="{{ route('front.trips.departure-booking', ['slug' => $departure->trip->slug, 'id' => $departure->id]) }}"
            class="btn btn-sm btn-accent">Join Group</a>
    </div>
</div>
