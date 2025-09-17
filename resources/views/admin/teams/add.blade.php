@extends('layouts.admin')
@push('styles')
    <style>
        #multiple-file {
            padding: 0px;
        }

        #multiple-file li {
            display: inline-flex;
            margin-top: 6px;
            background-color: #b5b5b5;
            padding-top: 9px;
            list-style-type: none;
            padding-bottom: 12px;
            margin-bottom: 3px;
            margin-right: 3px;
            color: white;
            padding-right: 12px;
            border-radius: 5px;
            padding-left: 12px;
            margin-right: 5px;
        }

        .remove-file {
            cursor: pointer;
            padding: 4px 0px 0px 10px;
        }

        #multiple-picture {
            padding: 0px;
        }

        #multiple-picture li {
            display: inline-flex;
            margin-top: 6px;
            background-color: #b5b5b5;
            padding-top: 9px;
            list-style-type: none;
            padding-bottom: 12px;
            margin-bottom: 3px;
            margin-right: 3px;
            color: white;
            padding-right: 12px;
            border-radius: 5px;
            padding-left: 12px;
            margin-right: 5px;
        }

        .remove-picture {
            cursor: pointer;
            padding: 4px 0px 0px 10px;
        }
    </style>
@endpush
@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <form class="kt-form"
                          id="add-form-team"
                          enctype="multipart/form-data">

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i class="kt-font-brand flaticon-business"></i>
                                </span>
                                <h3 class="kt-portlet__head-title">
                                    Add Team
                                </h3>
                            </div>
                            <div class="mt-3 kt-form__actions">
                                <a href="{{ route('admin.teams.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="flaticon2-arrow-up"></i>
                                    Publish</button>
                            </div>
                        </div>
                        <!--begin::Form-->
                        {{ csrf_field() }}
                        <div class="kt-portlet__body">
                            <div class="form-group">
                                <label for="">Team Image</label>
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
                                <label>Name</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       aria-describedby=""
                                       placeholder="Name"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select name="type"
                                        id=""
                                        class="form-control form-control-sm">
                                    <option value="1">Administration</option>
                                    <option value="2">Representatives</option>
                                    <option value="3">Tour Guides</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Position</label>
                                <input type="text"
                                       name="position"
                                       class="form-control"
                                       aria-describedby=""
                                       placeholder="Position"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="editor"></textarea>
                            </div>

                            {{-- files --}}
                            <div class="form-group">
                                <label>Certificates</label>
                                <div class="col">
                                    <div class="row">
                                        <button id="add-files-btn" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Add
                                            Certificate</button>
                                        <input style="display: none;"
                                               id="fileupload"
                                               type="file"
                                               name="files"
                                               multiple>
                                    </div>
                                    <div class="row">
                                        <ul id="multiple-file">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- galleries --}}
                            <div class="form-group">
                                <label>Galleries</label>
                                <div class="col">
                                    <div class="row">
                                        <button id="add-pictures-btn" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Add
                                            picture</button>
                                        <input style="display: none;"
                                               id="pictureupload"
                                               type="file"
                                               name="pictures"
                                               multiple>
                                    </div>
                                    <div class="row">
                                        <ul id="multiple-picture">
                                        </ul>
                                    </div>
                                </div>
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
    <script src="{{ asset('assets/vendors/file-upload/js/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('assets/vendors/file-upload/js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('assets/vendors/file-upload/js/jquery.fileupload.js') }}"></script>
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(function() {
            let file_count = 0;
            let files_arr = [];

            let picture_count = 0;
            let pictures_arr = [];

            $("#add-files-btn").on('click', function(event) {
                event.preventDefault();
                $("#fileupload").click();
            });

            $("#add-pictures-btn").on('click', function(event) {
                event.preventDefault();
                $("#pictureupload").click();
            });

            $(document).on('click', '.remove-file', function(event) {
                let e = $(this);
                let li = e.closest('li');
                let key = li.data('key');
                files_arr.splice(key, 1);
                li.remove();
            });

            $(document).on('click', '.remove-picture', function(event) {
                let e = $(this);
                let li = e.closest('li');
                let key = li.data('key');
                pictures_arr.splice(key, 1);
                li.remove();
            });

            $("#fileupload").fileupload({
                add: function(e, data) {
                    let file_div = "<li data-key=" + files_arr.length + ">" + data.files[0].name +
                        " <i class='fas fa-times remove-file'></i></li>";
                    data.context = $("#multiple-file").append(file_div);
                    files_arr.push(data.files[0]);
                    // data.submit();
                },
                progress: function(e, data) {
                    var progress = parseInt((data.loaded / data.total) * 100, 10);
                    data.context.css("background-position-x", 100 - progress + "%");
                },
                done: function(e, data) {
                    data.context
                        .addClass("done")
                        .find("a")
                        .prop("href", data.result.files[0].url);
                }
            });

            $("#pictureupload").fileupload({
                add: function(e, data) {
                    let file_div = "<li data-key=" + pictures_arr.length + ">" + data.files[0].name +
                        " <i class='fas fa-times remove-picture'></i></li>";
                    data.context = $("#multiple-picture").append(file_div);
                    pictures_arr.push(data.files[0]);
                    // data.submit();
                },
                progress: function(e, data) {
                    var progress = parseInt((data.loaded / data.total) * 100, 10);
                    data.context.css("background-position-x", 100 - progress + "%");
                },
                done: function(e, data) {
                    data.context
                        .addClass("done")
                        .find("a")
                        .prop("href", data.result.files[0].url);
                }
            });

            $("#add-form-team").validate({
                submitHandler: function(form, event) {
                    event.preventDefault();
                    var btn = $(form).find('button[type=submit]').attr('disabled', true).html('Publishing...');
                    handleTeamAddForm(form);
                }
            });

            function handleTeamAddForm(form) {
                var form = $(form);
                var formData = new FormData(form[0]);

                // certificates
                files_arr.forEach(function(i, v) {
                    formData.append("files[]", i);
                });

                // galleries
                pictures_arr.forEach(function(i, v) {
                    formData.append("pictures[]", i);
                });

                $.ajax({
                    url: "{{ route('admin.teams.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status === 1) {
                            location.href = "{{ route('admin.teams.index') }}";
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
