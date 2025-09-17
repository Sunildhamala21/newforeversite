@extends('layouts.admin')
@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <form class="kt-form"
                          id="add-form-page"
                          enctype="multipart/form-data">

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon-business"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Add Banner
                                </h3>
                            </div>
                            <div class="mt-3 kt-form__actions">
                                <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-arrow-up"></i>
                                    Publish</button>
                            </div>
                        </div>
                        <!--begin::Form-->
                        {{ csrf_field() }}
                        <div class="kt-portlet__body">
                            <div class="form-group">
                                <label for="">Banner Image</label>
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="mb-3">
                                            <img id="cropper-image"
                                                 class="rounded-sm crop-img-div"
                                                 src="{{ asset('img/default.gif') }}">
                                        </div>
                                        <input type="file"
                                               name="file"
                                               id="cropper-upload">
                                        <div class="mt-2">Recommended size: 1600 x 1000</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>ALT Tag</label>
                                <input type="text"
                                       name="image_alt"
                                       class="form-control"
                                       placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Caption</label>
                                <input type="text"
                                       name="caption"
                                       class="form-control"
                                       placeholder="">
                            </div>
                            <div class="form-group">
                                <label>View More Button Link</label>
                                <input type="text"
                                       name="btn_link"
                                       class="form-control"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-arrow-up"></i>
                                    Publish</button>
                                {{-- <button type="submit" class="btn btn-success">Publish</button> --}}
                                {{-- <button type="reset" class="btn btn-secondary">Cancel</button> --}}
                            </div>
                        </div>
                        <!--end::Form-->
                </div>
                </form>

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
                    handleBannerAddForm(form);
                }
            });
            var cropped = false;
            const image = document.getElementById('cropper-image');
            var cropper = "";

            function handleBannerAddForm(form) {
                var form = $(form);
                var formData = new FormData(form[0]);
                if (cropper) {
                    formData.append('cropped_data', JSON.stringify(cropper.getData()));
                }

                $.ajax({
                    url: "{{ route('admin.banners.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    async: false,
                    success: function(res) {
                        if (res.status === 1) {
                            location.href = '{{ route('admin.banners.index') }}';
                        }
                    }
                });
            }

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
