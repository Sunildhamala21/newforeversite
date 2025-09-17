<div class="relative py-10">
    <div class="max-w-5xl px-4 mx-auto">
        <div class="grid gap-10 lg:grid-cols-3">
            <div>
                <img src="{{ asset('assets/front/img/plan-trip.webp') }}" alt="" loading="lazy" width="400"
                    height="400" class="border-2 border-gray-100 rounded-lg max-w-48 lg:max-w-full">
            </div>
            <div class="prose lg:px-4 lg:py-4 lg:col-span-2">
                <h2>
                    <div class="mb-4 text-3xl font-bold text-left text-gray-600 lg:text-4xl">
                        Plan your trip with Local Expert
                    </div>
                    <div class="text-2xl font-bold text-left text-gray-600 lg:text-3xl font-handwriting">
                        Discover the most authentic way to explore the world.
                    </div>
                </h2>
                <p>Feel free to inquire, and together, we'll design the perfect journey to suit your preferences and
                    desires.</p>
                @if (request()->routeIs('home'))
                    <a href="{{ route('front.plantrip') }}"
                        class="inline-block px-4 py-4 tracking-wide text-white no-underline uppercase bg-green-600 rounded-lg font-display hover:bg-green-700">Plan
                        Your Trip</a>
                @else
                    <a href="{{ route('front.contact.index') }}"
                        class="inline-block px-4 py-4 text-white no-underline bg-green-600 rounded-lg hover:bg-green-700">Contact
                        Us</a>
                @endif
            </div>
        </div>
    </div>
</div>
