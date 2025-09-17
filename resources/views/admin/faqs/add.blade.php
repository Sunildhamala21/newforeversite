@extends('layouts.admin')

@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <form class="kt-form"
                          id="add-form-faq"
                          enctype="multipart/form-data">

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon-business"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Add Faq
                                </h3>
                            </div>
                            <div class="mt-3 kt-form__actions">
                                <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-arrow-up"></i>
                                    Publish</button>
                            </div>
                        </div>
                        <!--begin::Form-->
                        {{ csrf_field() }}
                        <div class="kt-portlet__body">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="faq_category_id" class="form-control form-control-sm">
                                    <option value="">--Select Category--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       aria-describedby=""
                                       placeholder="Title"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>Content</label>
                                <textarea name="content" class="editor"></textarea>
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
            $("#add-form-faq").validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    var btn = $(form).find('button[type=submit]').attr('disabled', true).html('Publishing...');
                    handleFaqAddForm(form);
                }
            });

            function handleFaqAddForm(form) {
                var form = $(form);
                var formData = new FormData(form[0]);

                $.ajax({
                    url: "{{ route('admin.faqs.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status === 1) {
                            location.href = '{{ route('admin.faqs.index') }}';
                        }
                    }
                });
            }
        });
    </script>
@endpush
