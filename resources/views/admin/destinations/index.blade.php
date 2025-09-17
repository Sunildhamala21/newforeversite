@extends('layouts.admin')
@section('content')
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-earth-globe"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Destinations
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="dropdown dropdown-inline">
                        <a href="{{ route('admin.destinations.add') }}" class="btn btn-sm btn-brand btn-icon-sm">
                            <i class="flaticon2-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <!--begin: Search Form -->
            <div class="kt-form kt-form--label-right kt-margin-b-10">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="row align-items-center">
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-input-icon kt-input-icon--left">
                                    <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <!--begin: Datatable -->
            <div class="kt-datatable" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    </div>
</div>
<!-- end:: Content -->
@endsection
@push('scripts')
<script src="./assets/js/data-destination-list.js" data-id="destination-list-script" data-url="{{ url('/') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
		$('.kt_sweetalert_delete_page').on('click', function(e) {
		   /* swal.fire({
		        title: 'Are you sure?',
		        text: "You won't be able to revert this!",
		        type: 'warning',
		        showCancelButton: true,
		        confirmButtonText: 'Yes, delete it!',
		        cancelButtonText: 'No, cancel!',
		        reverseButtons: true
		    }).then(function(result){
		        if (result.value) {
		            swal.fire(
		                'Deleted!',
		                'Your file has been deleted.',
		                'success'
		            )
		            // result.dismiss can be 'cancel', 'overlay',
		            // 'close', and 'timer'
		        } else if (result.dismiss === 'cancel') {
		            swal.fire(
		                'Cancelled',
		                'Your imaginary file is safe :)',
		                'error'
		            )
		        }
		    });*/
		});

	});
</script>
@endpush