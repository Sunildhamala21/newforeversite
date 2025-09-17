@extends('layouts.admin')
@push('styles')
    <link href="./assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <form class="kt-form" id="add-form-blog" enctype="multipart/form-data">

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon-business"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Add Blog
                                </h3>
                            </div>
                            <div class="mt-3 kt-form__actions">
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-arrow-up"></i>
                                    Publish</button>
                            </div>
                        </div>
                        <!--begin::Form-->
                        {{ csrf_field() }}
                        <div class="kt-portlet__body">
                            <ul class="nav nav-tabs" id="tripTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tabs_1_1">
                                        <i class="la la-map-pin"></i> General
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tabs_1_2">
                                        <i class="la la-map-signs"></i> Seo Manager
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content trip-tab-form">
                                <div class="tab-pane active" id="kt_tabs_1_1" role="tabpanel">
                                    <div class="form-group">
                                        <label for="">Blog Image</label>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <img id="cropper-image" class="crop-img-div"
                                                        src="{{ asset('img/default.gif') }}">
                                                </div>
                                                <input type="file" name="file" id="cropper-upload">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="name" class="form-control" aria-describedby=""
                                            placeholder="Title" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input name="blog_date" readonly class="form-control datepicker"
                                            data-date-format="yyyy-mm-dd" aria-describedby="" placeholder=""
                                            value="{{ today()->toDateString() }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Choose Categories</label>
                                        <div class="kt-checkbox-list">
                                            @if ($categories)
                                                @foreach ($categories as $category)
                                                    <label class="kt-checkbox kt-checkbox--brand">
                                                        <input type="checkbox" name="blog_categories[]"
                                                            value="{{ $category->id }}"> {{ $category->name }}
                                                        <span></span>
                                                    </label>
                                                @endforeach
                                            @else
                                                <p>No Categories Added.</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Excerpt</label>
                                        <textarea name="toc" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="editor" name="description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tags</label>
                                        <select class="js-select" name="tags[]" multiple>
                                            @foreach ($tags as $tag)
                                                <option>{{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <hr />

                                    <div class="form-group">
                                        <label>Choose Similar Blogs</label>
                                        <div class="kt-checkbox-list">
                                            @if (iterator_count($blogs))
                                                @foreach ($blogs as $blog)
                                                    <label class="kt-checkbox kt-checkbox--brand">
                                                        <input type="checkbox" name="similar_blogs[]"
                                                            value="{{ $blog->id }}"> {{ $blog->name }}
                                                        <span></span>
                                                    </label>
                                                @endforeach
                                            @else
                                                <p>No blogs added.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- seo tab --}}
                                <div class="tab-pane" data-index="2" id="kt_tabs_1_2" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Title</label>
                                        <div class="col-lg-7">
                                            <textarea name="seo[meta_title]" class="form-control form-control-sm" id="" cols="30" rows="2"></textarea>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Keywords</label>
                                        <div class="col-lg-7">
                                            <textarea name="seo[meta_keywords]" class="form-control form-control-sm" id="" cols="30"
                                                rows="2"></textarea>
                                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Canonical Url</label>
                                        <div class="col-lg-7">
                                            <input type="text" id="input-trip-name" value=""
                                                class="form-control form-control-sm" name="seo[canonical_url]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Description</label>
                                        <div class="col-lg-7">
                                            <textarea name="seo[meta_description]" class="form-control form-control-sm" id="" cols="30"
                                                rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Social Image</label>
                                        <div class="col-lg-7">
                                            <div>
                                                <p id="social_image_name"></p>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-secondary btn-wide"
                                                    onclick="document.getElementById('social_image').click();"> Upload
                                                    Social Image
                                                </button>
                                            </div>
                                            <input type="file" style="display: none;" id="social_image"
                                                class="form-control form-control-sm" name="seo[social_image]">
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
    @vite('resources/js/admin/select.js')
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="./assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.datepicker').datepicker();
            $("#add-form-blog").validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    var btn = $(form).find('button[type=submit]').attr('disabled', true).html(
                        'Publishing...');
                    handleBlogAddForm(form);
                }
            });

            function handleBlogAddForm(form) {
                var form = $(form);
                var formData = new FormData(form[0]);

                $.ajax({
                    url: "{{ route('admin.blogs.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status === 1) {
                            location.href = '{{ route('admin.blogs.index') }}';
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
