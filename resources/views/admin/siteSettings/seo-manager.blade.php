<?php
if (session()->has('success_message')) {
    $success_message = session('success_message');
    session()->forget('success_message');
}
?>
@extends('layouts.admin')
@push('styles')
    <link href="./assets/vendors/general/summernote/dist/summernote.css"
          rel="stylesheet"
          type="text/css" />
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
                                Seo Manager
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="kt-portlet__body">
                        {{-- Contact us block --}}
                        <div class="tab-pane"
                             data-index="3"
                             id="kt_tabs_1_3"
                             role="tabpanel">
                            <form class="kt-form"
                                  method="POST"
                                  action="{{ route('admin.settings.seo-manager.store') }}"
                                  id="setting-contact-us-form"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Meta Title </label>
                                    <div class="col-lg-7">
                                        <input type="text"
                                               id="input-trip-name"
                                               class="form-control form-control-sm"
                                               name="meta_title"
                                               value="{{ Setting::get('homePageSeo')['meta_title'] ?? '' }}">
                                        {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Meta Keywords </label>
                                    <div class="col-lg-7">
                                        <textarea name="meta_keywords"
                                                  class="form-control"
                                                  id=""
                                                  cols="30"
                                                  rows="2">{{ Setting::get('homePageSeo')['meta_keywords'] ?? '' }}</textarea>
                                        {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">OG Title</label>
                                    <div class="col-lg-7">
                                        <input type="text"
                                               id="input-trip-name"
                                               class="form-control form-control-sm"
                                               name="og_title"
                                               value="{{ Setting::get('homePageSeo')['og_title'] ?? '' }}">
                                        {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">OG Site Name</label>
                                    <div class="col-lg-7">
                                        <input type="text"
                                               id="input-trip-name"
                                               class="form-control form-control-sm"
                                               name="og_site_name"
                                               value="{{ Setting::get('homePageSeo')['og_site_name'] ?? '' }}">
                                        {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">OG Description</label>
                                    <div class="col-lg-7">
                                        <textarea name="og_description"
                                                  class="form-control"
                                                  id=""
                                                  cols="30"
                                                  rows="2">{{ Setting::get('homePageSeo')['og_description'] ?? '' }}</textarea>
                                        {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{-- <pre>{{ Setting::get('homePage') }}</pre> --}}
                                    <label class="col-lg-2 col-form-label">Og Image</label>
                                    <div class="col-lg-7">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <img id="cropper-image"
                                                         class="crop-img-div"
                                                         src="{{ Setting::getSiteSettingImage(Setting::get('homePageSeo')['og_image'] ?? null) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden"
                                               id="cropped-data-input"
                                               name="cropped_data">
                                        <input type="file"
                                               name="file"
                                               id="cropper-upload">
                                        {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                    </div>
                                </div>
                                <hr>
                                <div class="kt-form__actions">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="flaticon2-arrow-up"></i>
                                        Save</button>
                                    {{-- <a href="{{ route('admin.settings.general') }}" class="btn btn-secondary">Cancel</a> --}}
                                </div>
                            </form>
                        </div>
                        {{-- end of contact us --}}
                    </div>
                    <!-- <div class="kt-portlet__foot">
                                          <div class="kt-form__actions">
                                              {{-- <button type="submit" class="btn btn-success">Publish</button> --}}
                                              {{-- <button type="reset" class="btn btn-secondary">Cancel</button> --}}
                                              <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="flaticon2-arrow-up"></i>
                                                  Publish</button>
                                          </div>
                                      </div> -->
                    <!--end::Form-->
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

            var cropped = false;
            const image = document.getElementById('cropper-image');
            var cropper = "";

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
        });
    </script>
@endpush
