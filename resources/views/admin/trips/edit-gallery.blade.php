@extends('layouts.admin')
@php
    $route = str_replace(':ID', $slider->trip_id, route('admin.trips.edit', [':ID']));
@endphp
@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <form class="kt-form"
                          id="add-form-page"
                          enctype="multipart/form-data">
                        <input type="hidden"
                               name="id"
                               value="{{ $slider->id }}">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon-edit-1"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Edit Trip Gallery
                                </h3>
                            </div>
                            <div class="mt-3 kt-form__actions">
                                <a href="{{ route('admin.trips.edit', $slider->trip_id) }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-check-mark"></i>
                                    Update
                                </button>
                            </div>
                        </div>
                        <!--begin::Form-->
                        {{ csrf_field() }}
                        <div class="kt-portlet__body">
                            <div class="form-group">
                                <label for="">Gallery Image</label>
                                <div class="row">
                                    <div class="col-lg-7">
                                        <img id="cropper-image"
                                             class="crop-img-div"
                                             src="{{ $slider->image_url }}">

                                        <input type="file"
                                               name="gallery"
                                               id="cropper-upload">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-1 form-group">
                                <label>ALT Tag</label>
                                <input type="text"
                                       value="{{ $slider->alt_tag }}"
                                       name="alt_tag"
                                       class="form-control"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-check-mark"></i>
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#add-form-page").validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    var btn = $(form).find('button[type=submit]').attr('disabled', true).html('Publishing...');
                    handleBannerForm(form);
                }
            });

            function handleBannerForm(form) {
                var form = $(form);
                var formData = new FormData(form[0]);

                $.ajax({
                    url: "{{ route('admin.trips.sliders.update') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    async: false,
                    success: function(res) {
                        if (res.status === 1) {
                            window.location.href = '{{ $route }}';
                        }
                    }
                });
            }
        });
    </script>
@endpush
