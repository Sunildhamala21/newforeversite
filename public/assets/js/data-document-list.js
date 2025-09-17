"use strict";
// Class definition

var url = document
  .querySelector('script[data-id="document-list-script"][data-url]')
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
						url: '/admin/documents/list',
						method: 'GET'
					}
				},
				pageSize: 10,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false // display/hide footer
			},

			// column sorting
			sortable: true,

			pagination: true,

			search: {
				input: $('#generalSearch')
			},

			// columns definition
			columns: [
				{
					field: 'id',
					title: '#',
					sortable: false,
					width: 20,
					type: 'number',
					selector: {class: 'kt-checkbox--solid'},
					textAlign: 'center',
				},
				{
					field: 'name',
					title: 'Name'
				},
				{
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 110,
					autoHide: false,
					overflow: 'visible',
					template: function(item) {
						return '\
						<button class="btn btn-sm btn-clean btn-icon btn-icon-md kt_sweetalert_delete_page" data-id="'+item.id+'" title="Delete">\
							<i class="la la-trash"></i>\
						</button>\
						<a href="'+item.fileUrl+'" download target="_blank" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="download file">\
							<i class="la la-download"></i>\
						</a>\
					';
					},
				}
			],

		});

    $('#kt_form_status').on('change', function() {
      datatable.search($(this).val().toLowerCase(), 'Status');
    });

    $('#kt_form_type').on('change', function() {
      datatable.search($(this).val().toLowerCase(), 'Type');
    });

    $('#kt_form_status,#kt_form_type').selectpicker();

	};

	$(document).on('click', '.kt_sweetalert_delete_page', function(event) {
		var e = $(this);

		swal.fire({
		    title: 'Are you sure you want to delete this?',
		    // text: "You won't be able to revert this!",
		    type: 'warning',
		    showCancelButton: true,
		    confirmButtonText: 'Yes'
		}).then(function(result) {
		    if (result.value) {
		    	var id = e.attr('data-id');
		    	var action_url = url + '/admin/documents/delete/' + id; 
		    	$.ajax({
		    		url: action_url,
		    		type: "DELETE",
		    		dataType: "json",
		    		async: "false",
		    		success: function(res) {
		    			dataTable.reload();
		    			Toast.fire({
		    			  type: 'success',
		    			  title: 'The banner has been deleted.'
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
	setTimeout(function() {
		KTDatatableJsonRemoteDemo.init();
	}, 100);
});