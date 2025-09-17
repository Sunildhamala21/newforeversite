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
                        Bookings
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Booked by</th>
                            <th>Trips</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Type</th>
                            <th>Created at</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>
                                    <div>{{ implode(' ', [$booking->first_name, $booking->middle_name, $booking->last_name]) }}</div>
                                    <div>{{ $booking->country }}</div>
                                    <div>{{ $booking->phone }}</div>
                                    <div>{{ $booking->email }}</div>
                                </td>
                                <td>{{ $booking->trips->implode('name', ', ') }}</td>
                                <td class="text-right">US$ {{ number_format($booking->amount) }}</td>
                                <td>{{ ucfirst($booking->pay) }}</td>
                                <td>{{ ucfirst($booking->type) }}</td>
                                <td>{{ $booking->created_at->timezone('Asia/Kathmandu')->toDayDateTimeString() }}</td>
                                <td>
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-link">View</a>
                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end:: Content -->
@endsection
