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
                        Enquiry
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
                            <td>{{ $enquiry->id }}</td>
                        </tr>
                        <tr>
                            <td>Created at</td>
                            <td>{{ $enquiry->created_at->timezone('Asia/kathmandu')->toDayDateTimeString() }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{ $enquiry->name }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $enquiry->country }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><a href="mailto{{ $enquiry->email }}">{{ $enquiry->email }}</a></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $enquiry->phone }}</td>
                        </tr>
                        <tr>
                            <td>Message</td>
                            <td>{{ $enquiry->message }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end:: Content -->
@endsection
