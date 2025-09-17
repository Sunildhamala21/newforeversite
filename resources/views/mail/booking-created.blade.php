<x-layouts.mail :message="$message">
    <x-slot:heading>New booking</x-slot>
    <x-slot:body>
        <p style="color:white; margin-bottom: 0;">You have received a new booking on
            {{ $booking->created_at->timezone('Asia/Kathmandu')->toDayDateTimeString() }}.
        </p>
    </x-slot>

    <table class="data">
        <thead>
            <tr>
                <th>Trip</th>
                <th>No. of travelers</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($booking->trips as $trip)
                <tr>
                    <td>
                        <p><a href="{{ route('front.trips.show', $trip) }}">{{ $trip->name }}</a></p>
                        <p>
                            {{ Carbon\Carbon::parse($trip->pivot->start_date)->timezone('Asia/Kathmandu')->toFormattedDayDateString() }}
                            to <br>
                            {{ Carbon\Carbon::parse($trip->pivot->end_date)->timezone('Asia/Kathmandu')->toFormattedDayDateString() }}
                        </p>
                    </td>
                    <td>{{ $trip->pivot->no_of_travelers }} pax</td>
                    <td style="text-align: right;">US$ {{ number_format($trip->pivot->price) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <p style="text-align: right;">Amount</p>
                </td>
                <td>
                    <p class="d" style="text-align: right;">US$ {{ number_format($booking->amount) }}</p>
                </td>
            </tr>
        </tfoot>
    </table>
    <p></p>

    <table class="data">
        <tr>
            <td colspan="2">
                <p>Name</p>
                <p class="d">{{ implode(' ', [$booking->first_name, $booking->middle_name, $booking->last_name]) }}
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Country</p>
                <p class="d">{{ $booking->country }}</p>
            </td>
            <td>
                <p>Gender</p>
                <p class="d">{{ ucfirst($booking->gender) }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Email</p>
                <p class="d">{{ $booking->email }}</p>
            </td>
            <td>
                <p>Phone</p>
                <p class="d">{{ $booking->phone }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Type</p>
                <p class="d">{{ ucfirst($booking->type) }}</p>
            </td>
            <td>
                <p>Pay</p>
                <p class="d">{{ ucfirst($booking->pay) }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p>Message</p>
                <p class="d">{{ $booking->message }}</p>
            </td>
        </tr>
    </table>
</x-layouts.mail>
