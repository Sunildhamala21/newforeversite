<?php
  if (session()->has('success_message')) {
    $success_message = session('success_message');
    session()->forget('success_message');
  }
?>
@extends('layouts.admin')
@section('content')
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-laptop"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Subscribers
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    {{-- <a href="#" class="btn btn-clean btn-icon-sm">
                        <i class="la la-long-arrow-left"></i>
                        Back
                    </a> --}}
                    &nbsp;
                    <div class="dropdown dropdown-inline">
                        <a id="export-btn" href="{{ route('admin.subscribers.export-excel') }}" class="btn btn-sm btn-brand btn-icon-sm">
                            <i class="fas fa-file-export"></i> Export To Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <!--begin: Search Form -->
            <div class="kt-form kt-form--label-right kt-margin-b-10">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="row align-items-center">
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-input-icon kt-input-icon--left">
                                    <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <!--begin: Datatable -->
            <div class="kt-datatable" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    </div>
</div>
<!-- end:: Content -->
@endsection
@push('scripts')
<script src="./assets/js/data-subscriber-list.js" data-id="subscriber-list-script" data-url="{{ url('/') }}" type="text/javascript"></script>
<script>
    var success_message = '{{ $success_message ?? '' }}';
    if (success_message) {
      Toast.fire({
        type: 'success',
        title: success_message
      })
    }

    $("#export-btn").on('click', function(event) {
        setTimeout(function() {
            location.reload();
        }, 1000)
    });
</script>
@endpush