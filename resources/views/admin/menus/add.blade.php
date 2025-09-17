@extends('layouts.admin')
@push('styles')
<link href="./assets/vendors/general/summernote/dist/summernote.css" rel="stylesheet" type="text/css" />
<link href="./assets/css/drag-drop.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
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
                                Add Menu
                            </h3>
                        </div>
                        <div class="kt-form__actions mt-3">
                            <a href="{{ route('admin.menus.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="flaticon2-arrow-up"></i>
                                Publish</button>
                        </div>
                    </div>
                    <!--begin::Form-->
                    {{ csrf_field() }}
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <label class="col-lg-1 col-form-label">Name</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="name" value="primary" placeholder="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <menu id="nestable-menu" class="pull-right">
                                    <button type="button" class="ml-2 btn btn-bold btn-label-brand btn-square btn-sm pull-right" data-backdrop="static" data-toggle="modal" data-target="#kt_modal_4">Add Custom Link</button>
                                    <button class="btn btn-sm btn-outline-brand btn-elevate btn-square" type="button" data-action="expand-all">Expand All
                                        <i class="flaticon2-arrow-1"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-brand btn-elevate btn-square" type="button" data-action="collapse-all">Collapse All
                                        <i class="flaticon2-size"></i>
                                    </button>
                                </menu>
                                <div class="cf nestable-lists">
                                    <div class="dd" id="nestable">
                                        <ol class="dd-list">
                                            @if($pages)
                                              <li class="dd-item" data-type="main" data-name="pages" data-id="1">
                                                  <div class="dd-handle">Pages</div>
                                                  <ol class="dd-list">
                                                  @foreach($pages as $page)
                                                    <li class="dd-item" data-type="page" data-name="<?= $page->name; ?>" data-id="<?= $page->id; ?>">
                                                        <div class="dd-handle">{{ $page->name }}</div>
                                                    </li>
                                                  @endforeach
                                                  </ol>
                                              </li>
                                            @endif
                                            @if($destinations)
                                              <li class="dd-item" data-type="main" data-name="destinations" data-id="2">
                                                  <div class="dd-handle">Destinations</div>
                                                  <ol class="dd-list">
                                                  @foreach($destinations as $destination)
                                                    <li class="dd-item" data-type="destination" data-name="<?= $destination->name; ?>" data-id="<?= $destination->id; ?>">
                                                        <div class="dd-handle">{{ $destination->name }}</div>
                                                    </li>
                                                  @endforeach
                                                  </ol>
                                              </li>
                                            @endif
                                            @if($trips)
                                              <li class="dd-item" data-type="main" data-name="packages" data-id="3">
                                                  <div class="dd-handle">Packages</div>
                                                  <ol class="dd-list">
                                                  @foreach($trips as $trip)
                                                    <li class="dd-item" data-type="trip" data-name="<?= $trip->name; ?>" data-id="<?= $trip->id; ?>">
                                                        <div class="dd-handle">{{ $trip->name }}</div>
                                                    </li>
                                                  @endforeach
                                                  </ol>
                                              </li>
                                            @endif
                                            @if($activities)
                                              <li class="dd-item" data-type="main" data-name="activities" data-id="4">
                                                  <div class="dd-handle">Activities</div>
                                                  <ol class="dd-list">
                                                  @foreach($activities as $activity)
                                                    <li class="dd-item" data-type="activity" data-name="<?= $activity->name; ?>" data-id="<?= $activity->id; ?>">
                                                        <div class="dd-handle">{{ $activity->name }}</div>
                                                    </li>
                                                  @endforeach
                                                  </ol>
                                              </li>
                                            @endif
                                            @if($regions)
                                              <li class="dd-item" data-type="main" data-name="regions" data-id="4">
                                                  <div class="dd-handle">Regions</div>
                                                  <ol class="dd-list">
                                                  @foreach($regions as $region)
                                                    <li class="dd-item" data-type="region" data-name="<?= $region->name; ?>" data-id="<?= $region->id; ?>">
                                                        <div class="dd-handle">{{ $region->name }}</div>
                                                    </li>
                                                  @endforeach
                                                  </ol>
                                              </li>
                                            @endif
                                        </ol>
                                    </div>
                                    <div class="dd" id="nestable2">
                                        <ol class="dd-empty">
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-success">Publish</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div> --}}
                    <!--end::Form-->
            </div>
            </form>
            <!--end::Portlet-->
        </div>
    </div>
</div>
<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Custom Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="kt-form" id="add-link-form">
              {{ csrf_field() }}
              <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">Link Name</label>
                    <input type="text" name="name" required="required" class="form-control">
                </div>
                <div class="form-group">
                    <label for="recipient-url" class="form-control-label">URL</label>
                    <input type="text" name="link" required="required" class="form-control">
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add Link</button>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="./assets/vendors/general/summernote/dist/summernote.js" type="text/javascript"></script>
<script src="./assets/js/demo1/pages/crud/forms/widgets/summernote.js" type="text/javascript"></script>
<script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="./assets/vendors/nestable/jquery.nestable.js"></script>
<script type="text/javascript">
$(function() {
    var updateOutput = function(e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    // activate Nestable for list 1
    $('#nestable').nestable({
            group: 1
        })
        .on('change', updateOutput);

    // activate Nestable for list 2
    $('#nestable2').nestable({
            group: 1
        })
        .on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $('#nestable-menu').on('click', function(e) {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $("#add-form-page").validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            var btn = $(form).find('button[type=submit]').attr('disabled', true).html('Publishing...');
            handleMenuAddForm(form);
        }
    });

    function handleMenuAddForm(form) {
        var form = $(form);
        var formData = new FormData(form[0]);
        formData.append('menu_items', window.JSON.stringify($('#nestable2').nestable('serialize')));

        $.ajax({
            url: "{{ route('admin.menus.store') }}",
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            async: false,
            success: function(res) {
                if (res.status === 1) {
                    location.href = '{{ route('admin.menus.index') }}';
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

    $("#add-link-form").validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            // var btn = $(form).find('button[type=submit]').attr('disabled', true).html('Publishing...');
            handleLinkAddForm(form);
        }
    });

    function handleLinkAddForm(form) {
        var form = $(form);
        var formData = form.serializeArray();
        var ul = $("#nestable2>ol");

        var li = '<li class="dd-item" data-link="'+formData[2].value+'" data-type="custom" data-name="'+formData[1].value+'" data-id="0">\
                    <div class="dd-handle">'+formData[1].value+'</div>\
                </li>';
        ul.prepend(li).removeClass('dd-empty').addClass('dd-list');
        $('#kt_modal_4').modal('hide');
        $("#add-link-form")[0].reset();
    }
});

</script>
@endpush
