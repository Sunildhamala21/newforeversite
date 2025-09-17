@extends('layouts.admin')

@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon-earth-globe"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Album
                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Album</th>
                            <th>Photos</th>
                            <th>Created at</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($albums as $album)
                            <tr>
                                <td>{{ $album->id }}</td>
                                <td>
                                    {{ $album->name }}

                                    <button onclick="openEditDialog({{ $album->id }}, '{{ $album->name }}')"
                                        class="btn btn-font-primary">
                                        Edit
                                    </button>
                                </td>
                                <td>{{ $album->media->count() }}</td>
                                <td>{{ $album->created_at->toFormattedDateString() }}</td>
                                <td>
                                    <a href="{{ route('admin.albums.media.index', $album) }}"
                                        class="btn btn-sm btn-link">View</a>
                                    <button onclick="openDeleteDialog({{ $album->id }}, '{{ $album->name }}')"
                                        class="btn btn-font-primary">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('admin.albums.store') }}" method="post">
                    @csrf

                    <h4 class="mt-5">Add new album</h4>
                    <div class="row align-items-end">
                        <div class="col-3">
                            <div class="mb-0 form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <dialog id="editDialog" class="p-4 border rounded-lg shadow-lg w-25">
        <form id="editForm" class="space-y-4">
            <h4>Edit Album</h4>
            <input type="hidden" name="id" id="editId">
            <div class="form-group">
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="editName" class="form-control" required>
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
            <h4>Delete Album</h4>
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

    @push('scripts')
        <script>
            function openEditDialog(id, name) {
                document.getElementById('editId').value = id;
                document.getElementById('editName').value = name;
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

                try {
                    const response = await axios.post('/admin/albums/' + id, {
                        name: name,
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
                    const response = await axios.post('/admin/albums/' + id, {
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
@endsection
