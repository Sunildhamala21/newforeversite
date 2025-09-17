"use strict";
// Class definition

var url = document
	.querySelector('script[data-id="region-list-script"][data-url]')
	.getAttribute('data-url');
var trip_id = document
	.querySelector('script[data-id="region-list-script"][data-url]')
	.getAttribute('data-trip-id');
var KTDatatableJsonRemoteDemo = function () {
	// Private functions
	var dataTable;
	var categoryList;

	// basic demo
	var demo = function () {

		dataTable = $('.kt-datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				method: 'get',
				source: {
					read: {
						url: '/admin/trip-faqs/' + trip_id,
						method: 'GET'
					}
				},
				pageSize: 100,
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
					selector: { class: 'kt-checkbox--solid' },
					textAlign: 'center',
				},
				{
					field: 'title',
					title: 'Question',
				},
				{
					field: 'category',
					title: 'Category',
					template: function (item) {
						let option = "";
						$.each(categoryList, function (i, v) {
							let selected = "";
							if (v.id == item.faq_category_id) {
								selected = "selected";
							}
							option += '<option value="' + v.id + '" ' + selected + '>' + v.name + '</option>';
						});
						return '\
						<select data-id="'+ item.id + '" class="form-control form-control-sm category-select">\
							<option>--Select Category--</option>\
							'+ option + '\
						</select>\
						';
					}
				},
				// {
				// 	field: 'status',
				// 	title: 'Publish',
				// 	template: function(item) {
				// 		return '\
				// 		<div class="col-3">\
				// 		  <span class="kt-switch kt-switch--sm kt-switch--icon">\
				// 		  <label>\
				// 		  <input type="checkbox" data-id="'+item.id+'" '+((item.status)?"checked":"") +' id="publishSwitch" value="1" name="show_status">\
				// 		  <span></span>\
				// 		  </label>\
				// 		  </span>\
				// 		</div>\
				// 	';
				// 	},
				// },
				{
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 110,
					autoHide: false,
					overflow: 'visible',
					template: function (item) {
						return '\
						<a href="'+ url + '/admin/trip-faqs/edit/' + item.id + '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">\
							<i class="la la-edit"></i>\
						</a>\
						<button class="btn btn-sm btn-clean btn-icon btn-icon-md kt_sweetalert_delete_page" data-id="'+ item.id + '" title="Delete">\
							<i class="la la-trash"></i>\
						</button>\
					';
					},
				}
			],

		});

		$('#kt_form_status').on('change', function () {
			datatable.search($(this).val().toLowerCase(), 'Status');
		});

		$('#kt_form_type').on('change', function () {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_form_status,#kt_form_type').selectpicker();

	};

	function fetchCategoryList(categoryId) {
		var action_url = url + '/admin/faq-categories/list';
		$.ajax({
			url: action_url,
			type: "GET",
			dataType: "json",
			async: "false",
			success: function (res) {
				categoryList = res.data;
				demo();
			}
		})
	}

	$(document).on('change', '.category-select', function (event) {
		let id = $(this).val();
		let faq_id = $(this).data('id');

		var action_url = url + '/admin/trip-faqs/update-category/' + faq_id;
		$.ajax({
			url: action_url,
			type: "POST",
			dataType: "json",
			data: { category_id: id },
			async: "false",
			success: function (res) {
				// dataTable.reload();
				if (res.success) {
					Toast.fire({
						type: 'success',
						title: 'Category updated.'
					})
				}
			}
		})
	});

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
				var action_url = url + '/admin/trip-faqs/delete/' + id;
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
			fetchCategoryList();
		}
	};
}();

jQuery(document).ready(function () {
	setTimeout(function () {
		KTDatatableJsonRemoteDemo.init();
	}, 100);
});