@extends('layouts.admin')
@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <form class="kt-form" id="add-form-blog" enctype="multipart/form-data">
                        @method('put')

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon-business"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Edit Blog Category
                                </h3>
                            </div>
                            <div class="kt-form__actions mt-3">
                                <a href="{{ route('admin.blog-categories.index') }}"
                                    class="btn btn-sm btn-secondary">Cancel</a>
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
                                        <label for="">Blog Cateogry Image</label>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <img id="cropper-image" class="crop-img-div"
                                                        src="{{ $category->getFirstMediaUrl('default', 'large') ?? asset('img/default.gif') }}">
                                                </div>
                                                <input type="file" name="file" id="cropper-upload">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $category->name }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="editor">{{ $category->description }}</textarea>
                                    </div>

                                </div>

                                {{-- seo tab --}}
                                <div class="tab-pane" data-index="2" id="kt_tabs_1_2" role="tabpanel">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Title</label>
                                        <div class="col-lg-7">
                                            <textarea name="seo[meta_title]" class="form-control form-control-sm" id="" cols="30" rows="2">{{ $category->seo?->meta_title }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Keywords</label>
                                        <div class="col-lg-7">
                                            <textarea name="seo[meta_keywords]" class="form-control form-control-sm" id="" cols="30" rows="2">{{ $category->seo?->meta_keywords }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Canonical Url</label>
                                        <div class="col-lg-7">
                                            <input type="text" id="input-trip-name"
                                                value="{{ $category->seo?->canonical_url }}"
                                                class="form-control form-control-sm" name="seo[canonical_url]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Meta Description</label>
                                        <div class="col-lg-7">
                                            <textarea name="seo[meta_description]" class="form-control form-control-sm" id="" cols="30"
                                                rows="2">{{ $category->seo?->meta_description }}</textarea>
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
                    url: "{{ route('admin.blog-categories.update', $category) }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    async: false,
                    success: function(res) {
                        if (res.status === 1) {
                            location.href = '{{ route('admin.blog-categories.index') }}';
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
