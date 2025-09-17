$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
  error: function (jqXHR, textStatus, errorThrown) {
    var status = jqXHR.status;
    if (status == 404) {
      toastr.warning("Element not found.");
    } else if (status == 422) {
      toastr.info(jqXHR.responseJSON.message);
    }
  }
});