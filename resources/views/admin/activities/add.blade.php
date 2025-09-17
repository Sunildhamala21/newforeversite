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
                                    Add Activity
                                </h3>
                            </div>
                            <div class="mt-3 kt-form__actions">
                                <a href="{{ route('admin.activities.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-arrow-up"></i>
                                    Publish</button>
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
                                        <label for="">Activity Image</label>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <img id="cropper-image"
                                                         class="crop-img-div"
                                                         src="{{ asset('img/default.gif') }}">
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
                                               name="name"
                                               class="form-control"
                                               aria-describedby="emailHelp"
                                               placeholder="Title"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <div class="kt-checkbox-list">
                                                @if ($destinations)
                                                    @foreach ($destinations as $country)
                                                        <label class="kt-checkbox kt-checkbox--brand">
                                                            <input type="checkbox"
                                                                   name="destinations[]"
                                                                   value="{{ $country->id }}"> {{ $country->name }}
                                                            <span></span>
                                                        </label>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="editor" name="description"></textarea>
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
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-arrow-up"></i>
                                    Publish</button>
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
                    handlePageAddForm(form);
                }
            });

            function handlePageAddForm(form) {
                var form = $(form);
                var formData = new FormData(form[0]);

                $.ajax({
                    url: "{{ route('admin.activities.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status === 1) {
                            location.href = '{{ route('admin.activities.index') }}';
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
