@extends('layouts.admin')
@push('styles')
<link href="./assets/vendors/bootstrap-rating-master/bootstrap-rating.css" rel="stylesheet">
<link href="./assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
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
                              <i class="kt-font-brand flaticon-edit-1"></i>
                          </span>
                            <h3 class="kt-portlet__head-title">
                                Edit Trip Departure <small>{{ $trip->name }}</small>
                            </h3>
                        </div>
                        <div class="kt-form__actions mt-3">
                            <a href="{{ route('admin.trip-departures.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
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
                          <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                          <!-- <select class="custom-select form-control form-control-sm" name="trip_id">
                              <option value="">--Select Trip--</option>
                              @foreach($trips as $trip)
                              <option value="{{ $trip->id }}" <?php echo (($trip_id == $trip->id)?'selected':'');?>>{{ $trip->name }}</option>
                              @endforeach
                          </select> -->
                        </div>
                        <div id="trip-date-block">
                          @foreach($trip_departures as $key => $trip_departure)
                          <div data-repeater-item="" class="form-group row trip-departure-date-block">
                              <div class="col-md-3">
                                  <div class="kt-form__group--inline">
                                      <div class="kt-form__label">
                                          <label>From</label>
                                      </div>
                                      <div class="kt-form__control">
                                        <input name="trip_departures[{{ $key }}][from_date]" readonly class="form-control departure-start-datepicker" data-date-format="yyyy-mm-dd" aria-describedby="" value="{{ $trip_departure->from_date }}" placeholder="" required="required">
                                      </div>
                                  </div>
                                  <div class="d-md-none kt-margin-b-10"></div>
                              </div>
                              <div class="col-md-3">
                                  <div class="kt-form__group--inline">
                                      <div class="kt-form__label">
                                          <label class="kt-label m-label--single">To</label>
                                      </div>
                                      <div class="kt-form__control">
                                        <input name="trip_departures[{{ $key }}][to_date]" readonly class="form-control departure-to-datepicker" value="{{ $trip_departure->to_date }}" data-date-format="yyyy-mm-dd" aria-describedby="" placeholder="" required="required">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="kt-form__group--inline">
                                      <div class="kt-form__label">
                                          <label class="kt-label m-label--single">Seats</label>
                                      </div>
                                      <div class="kt-form__control">
                                        <input type="number" min="1" value="{{ $trip_departure->seats }}" name="trip_departures[{{ $key }}][seats]" class="form-control" aria-describedby="" placeholder="" required="required">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="kt-form__group--inline">
                                      <div class="kt-form__label">
                                          <label class="kt-label m-label--single">Price</label>
                                      </div>
                                      <div class="kt-form__control">
                                          <input type="number" min="1" value="{{ $trip_departure->price }}" class="form-control" name="trip_departures[{{ $key }}][price]" placeholder="" required="required">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="kt-form__group--inline">
                                      <div class="kt-form__label">
                                          <label class="kt-label m-label--single">Status</label>
                                      </div>
                                      <div class="kt-form__control">
                                        <select name="trip_departures[{{ $key }}][status]" class="form-control" id="">
                                          <option value="1" {{ ($trip_departure->status == 1)?'selected': '' }}>Guaranteed</option>
                                          <option value="2" {{ ($trip_departure->status == 2)?'selected': '' }}>Limited</option>
                                        </select>
                                      </div>
                                  </div>
                              </div>
                              @if($key > 0)
                              <button class="btn btn-sm btn-light btn-departure-date-remove" title="remove"><i class="fas fa-times"></i></button>
                              @endif
                          </div>
                          @endforeach
                        </div>
                        <button type="button" id="trip-date-add-btn" class="btn btn-sm btn-success btn-elevate btn-circle btn-icon pull-right" style="align-self: flex-end;"><i class="fas fa-plus"></i></button>
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
<script src="./assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
$(function() {

  var departure_count = {{ count($trip_departures) }};
  var dateToday = new Date();
  function init_date_picker() {

    $(".departure-start-datepicker").datepicker({
      startDate: dateToday,
      toggleActive: true,
    }).on('changeDate', function(event) {
      var sd = $(this).datepicker('getDate');
      sd.setDate(sd.getDate() + 1);
      var to_date_picker = $(this).closest('.trip-departure-date-block').find('.departure-to-datepicker');

      to_date_picker.datepicker('destroy');
      to_date_picker.datepicker({
        startDate: sd
      });
      to_date_picker.datepicker('update', sd);
    });

    $(".departure-to-datepicker").datepicker();
  }

  init_date_picker();

	$("#add-form-page").validate({
		submitHandler: function(form, event) {
      event.preventDefault();
      var btn = $(form).find('button[type=submit]').attr('disabled', true).html('Publishing...');
      handleRegionForm(form);
	  }
	});

  function handleRegionForm(form) {
    var form = $(form);
    var formData = new FormData(form[0]);

    $.ajax({
        url: "{{ route('admin.trip-departures.update') }}",
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        async: false,
        success: function(res) {
            if (res.status === 1) {
                location.href = '{{ route('admin.trip-departures.index') }}';
            }
        }
    });
  }

  $("#trip-date-add-btn").on('click', function(event) {
    event.preventDefault();
    departure_count++;
    var block = '<div data-repeater-item="" class="form-group row trip-departure-date-block">\
        <div class="col-md-3">\
            <div class="kt-form__group--inline">\
                <div class="kt-form__label">\
                    <label>From</label>\
                </div>\
                <div class="kt-form__control">\
                  <input name="trip_departures['+departure_count+'][from_date]" readonly class="form-control departure-start-datepicker" data-date-format="yyyy-mm-dd" aria-describedby="" placeholder="" required="required">\
                </div>\
            </div>\
            <div class="d-md-none kt-margin-b-10"></div>\
        </div>\
        <div class="col-md-3">\
            <div class="kt-form__group--inline">\
                <div class="kt-form__label">\
                    <label class="kt-label m-label--single">To</label>\
                </div>\
                <div class="kt-form__control">\
                  <input name="trip_departures['+departure_count+'][to_date]" readonly class="form-control departure-to-datepicker" data-date-format="yyyy-mm-dd" aria-describedby="" placeholder="" required="required">\
                </div>\
            </div>\
        </div>\
        <div class="col-md-3">\
            <div class="kt-form__group--inline">\
                <div class="kt-form__label">\
                    <label class="kt-label m-label--single">Seats</label>\
                </div>\
                <div class="kt-form__control">\
                  <input type="number" min="1" name="trip_departures['+departure_count+'][seats]" class="form-control" aria-describedby="" placeholder="" required="required">\
                </div>\
            </div>\
        </div>\
        <div class="col-md-3">\
            <div class="kt-form__group--inline">\
                <div class="kt-form__label">\
                    <label class="kt-label m-label--single">Price</label>\
                </div>\
                <div class="kt-form__control">\
                    <input type="number" min="1" class="form-control" name="trip_departures['+departure_count+'][price]" placeholder="" required="required">   \
                </div>\
            </div>\
        </div>\
        <div class="col-md-3">\
            <div class="kt-form__group--inline">\
                <div class="kt-form__label">\
                    <label class="kt-label m-label--single">Status</label>\
                </div>\
                <div class="kt-form__control">\
                  <select name="trip_departures['+departure_count+'][status]" class="form-control" id="">\
                    <option value="1">Guaranteed</option>\
                    <option value="2">Limited</option>\
                  </select>\
                </div>\
            </div>\
        </div>\
        <button class="btn btn-sm btn-light btn-departure-date-remove" title="remove"><i class="fas fa-times"></i></button>\
    </div>';

    $("#trip-date-block").append(block);
    init_date_picker();
  });

  $(document).on('click', '.btn-departure-date-remove', function(event) {
    event.preventDefault();
    $(this).closest('.trip-departure-date-block').remove();
  });
});

</script>
@endpush
