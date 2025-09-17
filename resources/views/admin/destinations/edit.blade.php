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
                        <input type="hidden"
                               name="id"
                               value="{{ $destination->id }}">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon-edit-1"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Edit Destination
                                </h3>
                            </div>
                            <div class="mt-3 kt-form__actions">
                                <a href="{{ route('admin.destinations.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-check-mark"></i>
                                    Update
                                </button>
                            </div>
                        </div>
                        <!--begin::Form-->
                        {{ csrf_field() }}
                        <div class="kt-portlet__body">
                            <ul class="nav nav-tabs"
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
                                        <i class="la la-map-signs"></i> Seo Manager
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content trip-tab-form">
                                {{-- general tab --}}
                                <div class="tab-pane active"
                                     id="kt_tabs_1_1"
                                     role="tabpanel">
                                    <div class="form-group">
                                        <label for="">Destination Image</label>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <img id="cropper-image"
                                                         class="crop-img-div"
                                                         src="{{ $destination->image_url }}">
                                                </div>
                                                <input type="file"
                                                       name="file"
                                                       id="cropper-upload">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text"
                                               value="{{ $destination->name }}"
                                               name="name"
                                               class="form-control"
                                               aria-describedby="emailHelp"
                                               placeholder="Title"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="editor" name="description">{{ $destination->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tour Guide Description</label>
                                        <textarea class="editor" name="tour_guide_description">{{ $destination->tour_guide_description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tour Guide Image</label>
                                        @if (!empty($destination->tour_guide_image_name))
                                            <input type="hidden"
                                                   id="existing-tour-guide-image-status"
                                                   value="1"
                                                   name="has_tour_guide_image">
                                            <div id="tour-guide-image-name-block">
                                                <p><span id="tour-guide-image-name">{{ $destination->tour_guide_image_name }}</span><button id="remove-tour-guide-image-name-file-btn" class="btn btn-sm text-danger"><i class="fa fa-times"></i></button></p>
                                            </div>
                                        @endif
                                        <input type="file"
                                               id="tour-guide-image"
                                               class="form-control">
                                    </div>
                                </div>
                                {{-- end of general tab --}}
                                {{-- seo tab --}}
                                <div class="tab-pane"
                                     data-index="2"
                                     id="kt_tabs_1_2"
                                     role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Title</label>
                                        <div class="col-lg-7">
                                            <textarea name="seo[meta_title]"
                                                      class="form-control form-control-sm"
                                                      id=""
                                                      cols="30"
                                                      rows="2">{{ $destination->seo->meta_title ?? '' }}</textarea>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Keywords</label>
                                        <div class="col-lg-7">
                                            <textarea name="seo[meta_keywords]"
                                                      class="form-control form-control-sm"
                                                      id=""
                                                      cols="30"
                                                      rows="2">{{ $destination->seo->meta_keywords ?? '' }}</textarea>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Canonical Url</label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   id="input-trip-name"
                                                   value="{{ $destination->seo->canonical_url ?? '' }}"
                                                   class="form-control form-control-sm"
                                                   name="seo[canonical_url]">
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Description</label>
                                        <div class="col-lg-7">
                                            <textarea name="seo[meta_description]"
                                                      class="form-control form-control-sm"
                                                      id=""
                                                      cols="30"
                                                      rows="2">{{ $destination->seo->meta_description ?? '' }}</textarea>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Social Image</label>
                                        <div class="col-lg-7">
                                            <div>
                                                <p id="social_image_name">{{ $destination->seo->social_image ?? '' }}</p>
                                            </div>
                                            <div>
                                                <button type="button"
                                                        class="btn btn-sm btn-secondary btn-wide"
                                                        onclick="document.getElementById('social_image').click();"> Upload Social Image
                                                </button>
                                            </div>
                                            <input type="file"
                                                   style="display: none;"
                                                   id="social_image"
                                                   class="form-control form-control-sm"
                                                   name="seo[social_image]">
                                        </div>
                                    </div>
                                </div>
                                {{-- end of seo tab --}}
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                {{-- <button type="submit" class="btn btn-success">Publish</button> --}}
                                {{-- <button type="reset" class="btn btn-secondary">Cancel</button> --}}
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

            $("#remove-tour-guide-image-name-file-btn").on('click', function(event) {
                event.preventDefault();
                $("#remove-tour-guide-image-name").val('');
                $("#tour-guide-image-name-block").hide();
                $("#existing-tour-guide-image-status").val('0');
            });


            $("#add-form-page").validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    var btn = $(form).find('button[type=submit]').attr('disabled', true).html('Publishing...');
                    handleDestinationForm(form);
                }
            });

            function handleDestinationForm(form) {
                var form = $(form);
                var formData = new FormData(form[0]);

                const fileInput = $('#tour-guide-image');
                var file = fileInput[0].files[0];
                if (!file || file == undefined) {
                    file = "";
                }
                formData.append('tour_guide_image_name', file);

                $.ajax({
                    url: "{{ route('admin.destinations.update') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status === 1) {
                            // toastr.success(res.message);
                            location.href = "{{ route('admin.destinations.index') }}";
                            // form[0].reset();
                            // $('#cropper-image').attr('src', '{{ asset('img/default.gif') }}');
                            // if (cropped) {
                            //   cropper.destroy();
                            // }
                            // $('#summernote-description').summernote('reset');
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
