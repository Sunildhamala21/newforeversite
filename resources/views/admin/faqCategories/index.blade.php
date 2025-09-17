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
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-list"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Faq Categories
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        {{-- <a href="#" class="btn btn-clean btn-icon-sm">
                        <i class="la la-long-arrow-left"></i>
                        Back
                    </a> --}}
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <form action="{{ route('admin.faq-categories.store') }}" method="POST">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Icon <a href="{{ route('admin.icons') }}" target="_blank" class="ml-5">Find
                                                Icons</a></label>
                                        <input type="text" name="icon" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-sm btn-success">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="kt-portlet__body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->icon)
                                            <x-dynamic-component :component="str($category->icon)->prepend('icon-')" style="width:30px" />
                                        @endif
                                        {{ $category->icon }}
                                    </td>
                                    <td>
                                        <button
                                            onclick="openEditDialog({{ $category->id }}, '{{ $category->name }}', '{{ $category->icon }}')"
                                            class="btn btn-font-primary">
                                            Edit
                                        </button>
                                        <button onclick="openDeleteDialog({{ $category->id }}, '{{ $category->name }}')"
                                            class="btn btn-font-danger">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

    <dialog id="editDialog" class="p-4 border rounded-lg shadow-lg w-25">
        <form id="editForm" class="space-y-4">
            <h4>Edit FAQ Category</h4>
            <input type="hidden" name="id" id="editId">
            <div class="form-group">
                <label for="editName" class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="editName" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="editIcon" class="block text-sm font-medium">Icon</label>
                <input type="text" name="name" id="editIcon" class="form-control" required>
            </div>
            <div>
                <button type="button" onclick="closeEditDialog()" class="btn btn-label-brand">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
        </form>
    </dialog>

    <dialog id="deleteDialog" class="p-4 border rounded-lg shadow-lg w-25">
        <form id="deleteForm" class="space-y-4">
            <h4>Delete FAQ Category</h4>
            <p>Are you sure you want to delete <span id="deleteName" class="font-weight-bold"></span>?</p>
            <input type="hidden" name="id" id="deleteId">
            <div>
                <button type="button" onclick="closeDeleteDialog()" class="btn btn-label-brand">
                    Cancel
                </button>
                <button type="submit" class="btn btn-danger">
                    Delete
                </button>
            </div>
        </form>
    </dialog>
    <!-- end:: Content -->
@endsection
@push('scripts')
    <script>
        $(function() {
            var success_message = '{{ $success_message ?? '' }}';
            var error_message = '{{ $error_message ?? '' }}';
            if (success_message) {
                Toast.fire({
                    type: 'success',
                    title: success_message
                })
            }

            if (error_message) {
                toastr.error(error_message);
            }
        });
    </script>
@endpush
@push('scripts')
    <script>
        function openEditDialog(id, name, icon) {
            document.getElementById('editId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editIcon').value = icon;
            document.getElementById('editDialog').showModal();
        }

        function closeEditDialog() {
            document.getElementById('editDialog').close();
        }

        function openDeleteDialog(id, name) {
            document.getElementById('deleteId').value = id;
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteDialog').showModal();
        }

        function closeDeleteDialog() {
            document.getElementById('deleteDialog').close();
        }

        document.getElementById('editForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const name = document.getElementById('editName').value;
            const icon = document.getElementById('editIcon').value;

            try {
                const response = await axios.post('/admin/faq-categories/' + id, {
                    name: name,
                    icon: icon,
                    _method: 'PUT'
                });

                closeEditDialog();
                window.location.reload();
            } catch (error) {
                alert('Failed: ' + (error.response?.data?.message || 'Unknown error'));
            }
        });

        document.getElementById('deleteForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('deleteId').value;

            try {
                const response = await axios.post('/admin/faq-categories/' + id, {
                    _method: 'DELETE'
                });
                closeDeleteDialog();
                window.location.reload();
            } catch (error) {
                alert('Failed to delete: ' + (error.response?.data?.message || 'Unknown error'));
            }
        });
    </script>
@endpush
