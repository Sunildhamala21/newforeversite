"use strict";
// Class definition

var url = document
    .querySelector('script[data-id="trip-list-script"][data-url]')
    .getAttribute('data-url');
var KTDatatableJsonRemoteDemo = function () {
    // Private functions
    var dataTable;

    // basic demo
    var demo = function () {

        dataTable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                method: 'get',
                source: {
                    read: {
                        url: '/admin/trips/list',
                        method: 'GET',
                    }
                },
                pageSize: 10,
                saveState: true,
                serverPaging: true,
                serverFiltering: true,
            },

            // layout definition
            layout: {
                pagination: {
                    toolbar: {
                        pagination: true,
                        pageSizeSelect: [10, 20, 30, 50, 100], // Available page sizes
                    },
                },
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false, // display/hide footer,
                icons: {
                    pagination: {
                        next: 'la la-angle-right',
                        prev: 'la la-angle-left',
                        first: 'la la-angle-double-left',
                        last: 'la la-angle-double-right',
                        more: 'la la-ellipsis-h'
                    }
                }
            },

            // column sorting
            sortable: true,
            pagination: true,
            search: {
                input: $('#generalSearch'),
                delay: 400
            },

            // columns definition
            columns: [
                {
                    field: 'id',
                    title: '#',
                    sortable: false,
                    width: 20,
                    type: 'number',
                    selector: { class: 'kt-checkbox--solid' },
                    textAlign: 'center',
                },
                {
                    field: 'name',
                    title: 'Title',
                },
                {
                    field: 'block_1',
                    title: 'Block 1',
                    template: function (item) {
                        return '\
						<div class="col-3">\
						  <span class="kt-switch kt-switch--sm kt-switch--icon">\
						  <label>\
						  <input type="checkbox" data-id="'+ item.id + '" ' + ((item.block_1 == 1) ? "checked" : "") + ' id="block1Switch" value="1" name="show_status">\
						  <span></span>\
						  </label>\
						  </span>\
						</div>\
					';
                    },
                },
                {
                    field: 'block_2',
                    title: 'Block 2',
                    template: function (item) {
                        return '\
						<div class="col-3">\
						  <span class="kt-switch kt-switch--sm kt-switch--icon">\
						  <label>\
						  <input type="checkbox" data-id="'+ item.id + '" ' + ((item.block_2 == 1) ? "checked" : "") + ' id="block2Switch" value="1" name="show_status">\
						  <span></span>\
						  </label>\
						  </span>\
						</div>\
					';
                    },
                },
                {
                    field: 'block_3',
                    title: 'Block 3',
                    template: function (item) {
                        return '\
						<div class="col-3">\
						  <span class="kt-switch kt-switch--sm kt-switch--icon">\
						  <label>\
						  <input type="checkbox" data-id="'+ item.id + '" ' + ((item.block_3 == 1) ? "checked" : "") + ' id="block3Switch" value="1" name="show_status">\
						  <span></span>\
						  </label>\
						  </span>\
						</div>\
					';
                    },
                },
                {
                    field: 'Actions',
                    title: 'Actions',
                    sortable: false,
                    width: 110,
                    autoHide: false,
                    overflow: 'visible',
                    template: function (item) {
                        return '\
						<a href="'+ url + '/admin/trips/edit/' + item.id + '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">\
							<i class="la la-edit"></i>\
						</a>\
						<button class="btn btn-sm btn-clean btn-icon btn-icon-md kt_sweetalert_delete_page" data-id="'+ item.id + '" title="Delete">\
							<i class="la la-trash"></i>\
						</button>\
					';
                    },
                }
            ],
            toolbar: {
                layout: ['pagination', 'info']
            }
        });

        $(document).on('change', '#block1Switch', function (e) {
            var id = $(this).data('id');
            var action_url = url + '/admin/trips/update-block1/' + id;
            $.ajax({
                url: action_url,
                type: "GET",
                dataType: "json",
                async: "false",
                success: function (res) {
                    Toast.fire({
                        type: 'success',
                        title: res.message
                    })
                }
            })
        });

        $(document).on('change', '#block2Switch', function (e) {
            var id = $(this).data('id');
            var action_url = url + '/admin/trips/update-block2/' + id;
            $.ajax({
                url: action_url,
                type: "GET",
                dataType: "json",
                async: "false",
                success: function (res) {
                    Toast.fire({
                        type: 'success',
                        title: res.message
                    })
                }
            })
        });

        $(document).on('change', '#block3Switch', function (e) {
            var id = $(this).data('id');
            var action_url = url + '/admin/trips/update-block3/' + id;
            $.ajax({
                url: action_url,
                type: "GET",
                dataType: "json",
                async: "false",
                success: function (res) {
                    Toast.fire({
                        type: 'success',
                        title: res.message
                    })
                }
            })
        });

        $('#kt_form_status').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $('#kt_form_type').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_form_status,#kt_form_type').selectpicker();

    };

    $(document).on('click', '.kt_sweetalert_delete_page', function (event) {
        var e = $(this);

        swal.fire({
            title: 'Are you sure you want to delete this?',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then(function (result) {
            if (result.value) {
                var id = e.attr('data-id');
                var action_url = url + '/admin/trips/delete/' + id;
                $.ajax({
                    url: action_url,
                    type: "DELETE",
                    dataType: "json",
                    async: "false",
                    success: function (res) {
                        dataTable.reload();
                        Toast.fire({
                            type: 'success',
                            title: 'The page has been deleted.'
                        })
                    }
                })
            }
        });
    });

    return {
        // public functions
        init: function () {
            demo();
        }
    };
}();

jQuery(document).ready(function () {
    setTimeout(function () {
        KTDatatableJsonRemoteDemo.init();
    }, 100);
});
