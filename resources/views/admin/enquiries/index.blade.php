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
                        Enquiries
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
                            <th>Name</th>
                            <th>Country</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created at</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enquiries as $enquiry)
                            <tr>
                                <td>{{ $enquiry->id }}</td>
                                <td>{{ $enquiry->name }}</td>
                                <td>{{ $enquiry->country }}</td>
                                <td><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></td>
                                <td>{{ $enquiry->phone }}</td>
                                <td>{{ $enquiry->created_at->timezone('Asia/Kathmandu')->toDayDateTimeString() }}</td>
                                <td>
                                    <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="btn btn-sm btn-link">View</a>
                                    <form action="{{ route('admin.enquiries.destroy', $enquiry) }}" method="POST" class="d-inline">
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
