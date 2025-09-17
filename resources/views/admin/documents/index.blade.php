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
                    <i class="kt-font-brand flaticon2-image-file"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Legal Documents
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    {{-- <a href="#" class="btn btn-clean btn-icon-sm">
                        <i class="la la-long-arrow-left"></i>
                        Back
                    </a> --}}
                    &nbsp;
                    {{-- <div class="dropdown dropdown-inline">
                        <a href="{{ route('admin.banners.add') }}" class="btn btn-sm btn-brand btn-icon-sm">
                            <i class="flaticon2-plus"></i> Add New
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="kt-nav">
                                <li class="kt-nav__section kt-nav__section--first">
                                    <span class="kt-nav__section-text">Choose an action:</span>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-open-text-book"></i>
                                        <span class="kt-nav__link-text">Reservations</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-calendar-4"></i>
                                        <span class="kt-nav__link-text">Appointments</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-bell-alarm-symbol"></i>
                                        <span class="kt-nav__link-text">Reminders</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-contract"></i>
                                        <span class="kt-nav__link-text">Announcements</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-shopping-cart-1"></i>
                                        <span class="kt-nav__link-text">Orders</span>
                                    </a>
                                </li>
                                <li class="kt-nav__separator kt-nav__separator--fit">
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-rocket-1"></i>
                                        <span class="kt-nav__link-text">Projects</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-chat-1"></i>
                                        <span class="kt-nav__link-text">User Feedbacks</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <!--begin: Search Form -->
            <div class="kt-form kt-form--label-right kt-margin-b-10">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                    <div class="kt-form__group kt-form__group--inline">
                                        <div class="kt-form__label">
                                            <label>Name</label>
                                        </div>
                                        <div class="kt-form__control">
                                            <input type="text" name="name" class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                    <div class="kt-form__group kt-form__group--inline">
                                        <div class="kt-form__label">
                                            <label>Image</label>
                                        </div>
                                        <div class="kt-form__control">
                                            <input type="file" name="file" class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                    <div class="kt-form__group kt-form__group--inline">
                                        <div class="kt-form__control">
                                            <button type="submit" class="btn btn-sm btn-success">Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
<script src="./assets/js/data-document-list.js" data-id="document-list-script" data-url="{{ url('/') }}" type="text/javascript"></script>
<script>
    $(function() {
        var success_message = '{{ $success_message ?? '' }}';
        if (success_message) {
          Toast.fire({
            type: 'success',
            title: success_message
          })
        }
    });
</script>
@endpush