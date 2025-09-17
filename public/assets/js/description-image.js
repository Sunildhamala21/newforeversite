const SAVE_ROUTE = document.querySelector('script[data-id="description-image"]').getAttribute('data-save-url');
const DELETE_ROUTE = document.querySelector('script[data-id="description-image"]').getAttribute('data-delete-url');

  function deleteFile(src) {
      $.ajax({
          data: {src : src},
          type: "POST",
          url: DELETE_ROUTE, // replace with your url
          cache: false,
          success: function(resp) {
              console.log(resp);
          }
      });
  }

  function sendFile(file, el) {
    let data = new FormData();
    data.append("file", file);
    $.ajax({
        url: SAVE_ROUTE,
        data: data,
        type: "POST",
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        success: function(res) {
            $(el).summernote('editor.insertImage', res.data);
        }
    });
  }
