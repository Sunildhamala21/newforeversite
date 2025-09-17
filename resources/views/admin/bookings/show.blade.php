@extends('layouts.admin')
@section('content')
    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon-earth-globe"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Booking
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="dropdown dropdown-inline">
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
            </div>
            <div class="kt-portlet__body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#</td>
                            <td>{{ $booking->id }}</td>
                        </tr>
                        <tr>
                            <td>Created at</td>
                            <td>{{ $booking->created_at->timezone('Asia/kathmandu')->toDayDateTimeString() }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{ implode(' ', [$booking->first_name, $booking->middle_name, $booking->last_name]) }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $booking->country }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $booking->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $booking->phone }}</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>{{ ucfirst($booking->gender) }}</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td>US$ {{ number_format($booking->amount) }}</td>
                        </tr>
                        <tr>
                            <td>Pay</td>
                            <td>{{ ucfirst($booking->pay) }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>{{ ucfirst($booking->type) }}</td>
                        </tr>
                        <tr>
                            <td>Message</td>
                            <td>{{ $booking->message }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center" colspan="2">Trip</th>
                            <th class="text-center">No. of Travelers</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Start date</th>
                            <th class="text-center">End date</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking->trips as $trip)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ $trip->thumbImageUrl }}" alt="" class="rounded-lg"></td>
                                <td>
                                    <div class="font-weight-bold">{{ $trip->name }}</div>
                                    <div>{{ $trip->duration }} days</div>
                                </td>
                                <td class="text-right">{{ $trip->pivot->no_of_travelers }}</td>
                                <td class="text-right">US$ {{ number_format($trip->pivot->price) }}</td>
                                <td>{{ Carbon\Carbon::parse($trip->pivot->start_date)->toFormattedDayDateString() }}</td>
                                <td>{{ Carbon\Carbon::parse($trip->pivot->end_date)->toFormattedDayDateString() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td class="text-right font-weight-bold">US$ {{ number_format($booking->amount) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- end:: Content -->
@endsection
