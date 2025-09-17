@extends('layouts.admin')
@push('styles')
    <link href="./assets/vendors/general/summernote/dist/summernote.css" rel="stylesheet" type="text/css" />
    <link href="./assets/vendors/cropperjs/dist/cropper.min.css" rel="stylesheet">
    <link href="./assets/vendors/bootstrap-rating-master/bootstrap-rating.css" rel="stylesheet">
@endpush
@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <form class="kt-form" id="add-form-page" enctype="multipart/form-data">

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon-business"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Add Trip Faq
                                </h3>
                            </div>
                            <div class="mt-3 kt-form__actions">
                                <a href="{{ route('admin.trip-faqs.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-arrow-up"></i>
                                    Publish</button>
                            </div>
                        </div>
                        <!--begin::Form-->
                        {{ csrf_field() }}
                        <div class="kt-portlet__body">
                            <div class="form-group">
                                <label class="form-label">Trip</label>
                                <select class="custom-select form-control form-control-sm" name="trip_id">
                                    <option selected="" value="">--Select Trip--</option>
                                    @foreach ($trips as $trip)
                                        <option value="{{ $trip->id }}" @selected($currentTrip && $trip->id === $currentTrip->id)>{{ $trip->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select class="custom-select form-control form-control-sm" name="faq_category_id">
                                    <option value="">--Select Category--</option>
                                    @foreach ($faqCategories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="" cols="30" rows="10" class="editor"></textarea>
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
            $("#add-form-page").validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    var btn = $(form).find('button[type=submit]').attr('disabled', true).html(
                        'Publishing...');
                    handleFaqAddForm(form);
                }
            });
            var cropped = false;
            const image = document.getElementById('cropper-image');
            var cropper = "";

            function handleFaqAddForm(form) {
                var form = $(form);
                var formData = new FormData(form[0]);

                $.ajax({
                    url: "{{ route('admin.trip-faqs.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    async: false,
                    success: function(res) {
                        if (res.status === 1) {
                            location.href =
                                '{{ $currentTrip ? route('admin.trip-faqs.faqs', ['tripId' => $currentTrip->id]) : route('admin.trip-faqs.index') }}';
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
