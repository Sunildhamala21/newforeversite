<?php
if (session()->has('success_message')) {
    $success_message = session('success_message');
    session()->forget('success_message');
}
?>
@extends('layouts.admin')
@push('styles')
    <link href="./assets/vendors/bootstrap-rating-master/bootstrap-rating.css" rel="stylesheet">
@endpush
@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand flaticon2-settings"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                Site Settings
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="kt-portlet__body">

                        <ul class="nav nav-tabs trip-nav-tabs"
                            id="tripTab"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_1">
                                    <i class="la la-map-pin"></i> General
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_2">
                                    <i class="la la-map-signs"></i> Home Page
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_3">
                                    <i class="la la-phone"></i> Contact Us
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_4">
                                    <i class="la la-share-alt"></i> Get Connected
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   data-toggle="tab"
                                   href="#kt_tabs_1_5">
                                    <i class="la la-google"></i> 3rd Party Sources
                                </a>
                            </li>
                        </ul>

                        <div id="trip-tab" class="tab-content trip-tab-form">
                            <div class="tab-pane active"
                                 data-index="1"
                                 id="kt_tabs_1_1"
                                 role="tabpanel">
                                <form class="kt-form"
                                      method="POST"
                                      action="{{ route('admin.settings.general.store') }}"
                                      id="setting-form"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Site Name </label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="site_name"
                                                   value="{{ Setting::get('site_name') }}">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Email</label>
                                        <div class="col-lg-7">
                                            <input type="email"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="email"
                                                   value="{{ Setting::get('email') }}">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Telephone</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="telephone"
                                                   value="{{ Setting::get('telephone') }}">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Mobile 1</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="mobile1"
                                                   value="{{ Setting::get('mobile1') }}">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Mobile 2</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="mobile2"
                                                   value="{{ Setting::get('mobile2') }}">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Address</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="address"
                                                   value="{{ Setting::get('address') }}">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Office Time</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-office-time"
                                                   class="form-control form-control-sm"
                                                   name="office_time"
                                                   value="{{ Setting::get('office_time') }}">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="flaticon2-arrow-up"></i>
                                            Save</button>
                                        <a href="{{ route('admin.settings.general') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>

                            {{-- home page block --}}
                            <div class="tab-pane"
                                 data-index="2"
                                 id="kt_tabs_1_2"
                                 role="tabpanel">
                                <form class="kt-form"
                                      method="POST"
                                      action="{{ route('admin.settings.home-page.store') }}"
                                      id="setting-home-form"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{-- {{ dd(Setting::get('homePage')) }} --}}
                                    <h5>Welcome</h5>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Title </label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="welcome[title]"
                                                   value="{{ Setting::get('homePage')['welcome']['title'] ?? '' }}">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Sub Title </label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="welcome[sub_title]"
                                                   value="{{ Setting::get('homePage')['welcome']['sub_title'] ?? '' }}">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Content</label>
                                        <div class="col-lg-7">
                                            <input type="hidden" name="welcome[content]">
                                            <textarea name="welcome[content]" class="editor">{!! Setting::get('homePage')['welcome']['content'] ?? '' !!}</textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5>Trip Block 1</h5>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Title </label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="trip_block_1[title]"
                                                   value="{{ Setting::get('homePage')['trip_block_1']['title'] ?? '' }}">
                                        </div>
                                    </div>
                                    <hr>
                                    <h5>Trip Block 2</h5>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Title </label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="trip_block_2[title]"
                                                   value="{{ Setting::get('homePage')['trip_block_2']['title'] ?? '' }}">
                                        </div>
                                    </div>
                                    <h5>Trip Block 3</h5>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Title </label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="trip_block_3[title]"
                                                   value="{{ Setting::get('homePage')['trip_block_3']['title'] ?? '' }}">
                                        </div>
                                    </div>
                                    <hr>
                                    <h5>Video</h5>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Link </label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="video[link]"
                                                   value="{{ Setting::get('homePage')['video']['link'] ?? '' }}">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="kt-form__actions">
                                        <button type="submit"
                                                id="home-page-save-btn"
                                                class="btn btn-sm btn-primary">
                                            <i class="flaticon2-arrow-up"></i>
                                            Save</button>
                                        <a href="{{ route('admin.settings.general') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                            {{-- end of home page block --}}

                            {{-- Contact us block --}}
                            <div class="tab-pane"
                                 data-index="3"
                                 id="kt_tabs_1_3"
                                 role="tabpanel">
                                <form class="kt-form"
                                      method="POST"
                                      action="{{ route('admin.settings.contact-us.store') }}"
                                      id="setting-contact-us-form"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Title </label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   class="form-control form-control-sm"
                                                   name="title"
                                                   value="{{ Setting::get('contactUs')['title'] ?? '' }}">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Content </label>
                                        <div class="col-lg-7">
                                            <textarea name="content"
                                                      class="form-control"
                                                      id=""
                                                      cols="30"
                                                      rows="10">{{ Setting::get('contactUs')['content'] ?? '' }}</textarea>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Map Iframe</label>
                                        <div class="col-lg-7">
                                            <textarea name="map"
                                                      class="form-control"
                                                      id=""
                                                      cols="30"
                                                      rows="10">{{ Setting::get('contactUs')['map'] ?? '' }}</textarea>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="flaticon2-arrow-up"></i>
                                            Save</button>
                                        <a href="{{ route('admin.settings.general') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                            {{-- end of contact us --}}

                            {{-- get connected block --}}
                            <div class="tab-pane"
                                 data-index="4"
                                 id="kt_tabs_1_4"
                                 role="tabpanel">
                                <form class="kt-form"
                                      method="POST"
                                      action="{{ route('admin.settings.socialmedia.store') }}"
                                      id="setting-form">
                                    {{ csrf_field() }}

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Pinterest </label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-pinterest"
                                                   class="form-control form-control-sm"
                                                   name="pinterest"
                                                   value="{{ Setting::get('pinterest') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Facebook</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-facebook"
                                                   class="form-control form-control-sm"
                                                   name="facebook"
                                                   value="{{ Setting::get('facebook') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Instagram</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-instagram"
                                                   class="form-control form-control-sm"
                                                   name="instagram"
                                                   value="{{ Setting::get('instagram') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Twitter</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-twitter"
                                                   class="form-control form-control-sm"
                                                   name="twitter"
                                                   value="{{ Setting::get('twitter') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Flicker</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-flicker"
                                                   class="form-control form-control-sm"
                                                   name="flicker"
                                                   value="{{ Setting::get('flicker') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">What's App</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-whatsapp"
                                                   class="form-control form-control-sm"
                                                   name="whatsapp"
                                                   value="{{ Setting::get('whatsapp') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Viber</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-viber"
                                                   class="form-control form-control-sm"
                                                   name="viber"
                                                   value="{{ Setting::get('viber') }}">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="flaticon2-arrow-up"></i>
                                            Save</button>
                                        <a href="{{ route('admin.settings.general') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                            {{-- end of get connected block --}}

                            {{-- 3rd Party sources block --}}
                            <div class="tab-pane"
                                 data-index="5"
                                 id="kt_tabs_1_5"
                                 role="tabpanel">
                                <form class="kt-form"
                                      method="POST"
                                      action="{{ route('admin.settings.thirdPartySources.store') }}"
                                      id="setting-form">
                                    {{ csrf_field() }}

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Google Analytics </label>
                                        <div class="col-lg-7">
                                            <textarea type="text"
                                                      id="input-google_analytics"
                                                      class="form-control form-control-sm"
                                                      name="google_analytics"
                                                      rows="15">{{ Setting::get('thirdParty') ? Setting::get('thirdParty')['google_analytics'] : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">TripAdvisor Widget</label>
                                        <div class="col-lg-7">
                                            <textarea type="text"
                                                      id="input-google_analytics"
                                                      class="form-control form-control-sm"
                                                      name="tripadvisor_widget"
                                                      rows="15">{{ Setting::get('thirdParty') ? Setting::get('thirdParty')['tripadvisor_widget'] : '' }}</textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="flaticon2-arrow-up"></i>
                                            Save</button>
                                        <a href="{{ route('admin.settings.general') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                            {{-- end of 3rd party sources block --}}
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="./assets/vendors/general/summernote/dist/summernote.js" type="text/javascript"></script>
    <script src="./assets/js/demo1/pages/crud/forms/widgets/summernote.js" type="text/javascript"></script>
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="./assets/vendors/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="./assets/vendors/bootstrap-rating-master/bootstrap-rating.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function() {
            var success_message = '{{ $success_message ?? '' }}';
            if (success_message) {
                Toast.fire({
                    type: 'success',
                    title: success_message
                })
            }

            var validation_rules = {
                pdf_file_name: {
                    extension: "pdf"
                },
                map_file_name: {
                    extension: "jpeg|jpg|png|gif"
                },
                "trip_seo[og_image]": {
                    extension: "jpeg|jpg|png|gif"
                },
                cost: {
                    number: true
                },
                max_altitude: {
                    number: true
                },
                offer_price: {
                    number: true
                }
            };
            var validation_messages = {
                pdf_file_name: {
                    extension: "Only pdf is allowed."
                },
                map_file_name: {
                    extension: "Only image files is allowed."
                }
            };

            var cropped = false;
            const image = document.getElementById('cropper-image');
            var cropper = "";

            function handleBannerAddForm(form) {
                var form = $(form);
                var formData = new FormData(form[0]);
                if (cropper) {
                    formData.append('cropped_data', JSON.stringify(cropper.getData()));
                }
            }

            $("#home-page-save-btn").on('click', function(event) {
                event.preventDefault();
                if (cropper) {
                    $("#cropped-data-input").val(JSON.stringify(cropper.getData()));
                }
                $(this).closest('form').submit();
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#cropper-image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#cropper-upload").change(function() {
                readURL(this);
            });

            initSummerNote();
        });
    </script>
@endpush
