import toastr from 'toastr';

$('#email-subscribe-form').on('submit', function (event) {
  event.preventDefault();
  var form = $(this);
  var formData = form.serialize();
  $.ajax({
    url: form.attr('action'),
    type: "POST",
    data: formData,
    dataType: "json",
    async: "false",
    success: function (res) {
      if (res.status == 1) {
        toastr.success(res.message);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      var status = jqXHR.status;
      if (status == 404) {
        toastr.warning("Element not found.");
      } else if (status == 422) {
        toastr.warning(jqXHR.responseJSON.errors.email[0]);
      }
    }
  });
});