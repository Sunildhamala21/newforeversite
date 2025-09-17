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
                          <i class="kt-font-brand flaticon-business"></i>
                      </span>
                        <h3 class="kt-portlet__head-title">
                            Add Trip Departure
                        </h3>
                    </div>
                    <div class="kt-form__actions mt-3">
                        <a href="{{ route('admin.trip-departures.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
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
                          <select class="custom-select form-control form-control-sm" name="trip_id" required="required">
                              <option selected="" value="">--Select Trip--</option>
                              @foreach($trips as $trip)
                              <option value="{{ $trip->id }}">{{ $trip->name }}</option>
                              @endforeach
                          </select>
                        </div>
                        <div id="trip-date-block">
                          <div data-repeater-item="" class="form-group row trip-departure-date-block">
                              <div class="col-md-3">
                                  <div class="kt-form__group--inline">
                                      <div class="kt-form__label">
                                          <label>From</label>
                                      </div>
                                      <div class="kt-form__control">
                                        <input name="trip_departures[0][from_date]" readonly class="form-control departure-start-datepicker" data-date-format="yyyy-mm-dd" aria-describedby="" placeholder="" required="required">
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
                                        <input name="trip_departures[0][to_date]" readonly class="form-control departure-to-datepicker" data-date-format="yyyy-mm-dd" aria-describedby="" placeholder="" required="required">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="kt-form__group--inline">
                                      <div class="kt-form__label">
                                          <label class="kt-label m-label--single">Seats</label>
                                      </div>
                                      <div class="kt-form__control">
                                        <input type="number" min="1" name="trip_departures[0][seats]" class="form-control" aria-describedby="" placeholder="" required="required">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="kt-form__group--inline">
                                      <div class="kt-form__label">
                                          <label class="kt-label m-label--single">Price</label>
                                      </div>
                                      <div class="kt-form__control">
                                          <input type="number" min="1" class="form-control" name="trip_departures[0][price]" placeholder="" required="required">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="kt-form__group--inline">
                                      <div class="kt-form__label">
                                          <label class="kt-label m-label--single">Status</label>
                                      </div>
                                      <div class="kt-form__control">
                                        <select name="trip_departures[0][status]" class="form-control" id="">
                                          <option value="1">Guaranteed</option>
                                          <option value="2">Limited</option>
                                        </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <button type="button" id="trip-date-add-btn" class="btn btn-sm btn-success btn-elevate btn-circle btn-icon pull-right" style="align-self: flex-end;"><i class="fas fa-plus"></i></button>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            {{-- <button type="submit" class="btn btn-success">Publish</button> --}}
                            {{-- <button type="reset" class="btn btn-secondary">Cancel</button> --}}
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
<script src="./assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
$(function() {
  var departure_count = 0;
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
        handleDepartureAddForm(form);
		  }
		});

    function handleDepartureAddForm(form) {
      var form = $(form);
      var formData = new FormData(form[0]);

      $.ajax({
          url: "{{ route('admin.trip-departures.store') }}",
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
      var block = '<hr/><div data-repeater-item="" class="form-group row trip-departure-date-block">\
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
                      <input type="number" class="form-control" name="trip_departures['+departure_count+'][price]" placeholder="" required="required">   \
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
