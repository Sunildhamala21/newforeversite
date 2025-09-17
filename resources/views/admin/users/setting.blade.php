<?php
  if (session()->has('success_message')) {
    $success_message = session('success_message');
    session()->forget('success_message');
  }
  if (session()->has('error_message')) {
    $error_message = session('error_message');
    session()->forget('error_message');
  }
?>
@extends('layouts.admin')
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                  <div class="kt-portlet__head">
                      <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand flaticon2-settings"></i>
                        </span>
                          <h3 class="kt-portlet__head-title">
                              Admin User Manager
                          </h3>
                      </div>
                  </div>
                  <!--begin::Form-->
                  <div class="kt-portlet__body">
                      {{-- Contact us block --}}
                      <div class="tab-pane" data-index="3" id="kt_tabs_1_3" role="tabpanel">
                        <form class="kt-form" method="POST" action="{{ route('admin.user-setting.update') }}" id="user-form">
                          {{ csrf_field() }}
                          <!-- <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Email</label>
                            <div class="col-lg-7">
                              <input type="text" id="input-name" class="form-control form-control-sm" name="email" value="{{ $user['email'] }}" required>
                              {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                            </div>
                          </div> -->
                          <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Username</label>
                            <div class="col-lg-7">
                              <input type="text" id="input-username" class="form-control form-control-sm" name="username" value="{{ $user['username'] }}" required>
                              {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Password</label>
                            <div class="col-lg-7">
                              <input type="password" id="password" class="form-control form-control-sm" name="password">
                              {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Confirm Password</label>
                            <div class="col-lg-7">
                              <input type="password" id="confirm-password" class="form-control form-control-sm" name="confirm_password">
                              {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                            </div>
                          </div>
                          <hr>
                          <div class="kt-form__actions">
                            <button type="submit" class="btn btn-sm btn-primary">
                                  <i class="flaticon2-arrow-up"></i>
                                Update</button>
                            {{-- <a href="{{ route('admin.settings.general') }}" class="btn btn-secondary">Cancel</a> --}}
                          </div>
                        </form>
                      </div>
                      {{-- end of contact us --}}
                  </div>
                  <!-- <div class="kt-portlet__foot">
                      <div class="kt-form__actions">
                          {{-- <button type="submit" class="btn btn-success">Publish</button> --}}
                          {{-- <button type="reset" class="btn btn-secondary">Cancel</button> --}}
                          <button type="submit" class="btn btn-sm btn-primary">
                                <i class="flaticon2-arrow-up"></i>
                              Publish</button>
                      </div>
                  </div> -->
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="./assets/vendors/jquery-validation/dist/additional-methods.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
  var success_message = '{{ $success_message ?? '' }}';
  if (success_message) {
    Toast.fire({
      type: 'success',
      title: success_message
    })
  }

  var error_message = '{{ $error_message ?? '' }}';
  if (error_message) {
    Toast.fire({
      type: 'danger',
      title: error_message
    })
  }

  $( "#user-form" ).validate({
    rules: {
      password: {
        minlength: 6
      },
      confirm_password: {
        equalTo: "#password",
        required: function () {
            return $('#password').val().length > 0;
        }
      }
    }
  });
});

</script>
@endpush
