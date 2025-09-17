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
                        {{ $album->name }}
                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Caption</th>
                            <th>Created at</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($album->media as $media)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ $media->getUrl('thumb') }}" class="tbl-img"></td>
                                <td>{{ $media->getCustomProperty('caption') }}</td>
                                <td>{{ $media->created_at->toFormattedDateString() }}</td>
                                <td>
                                    <button
                                        onclick="openEditDialog({{ $album->id }}, {{ $media->id }}, '{{ $media->getCustomProperty('caption') }}')"
                                        class="btn btn-font-primary">
                                        Edit
                                    </button>
                                    <button
                                        onclick="openDeleteDialog({{ $album->id }}, {{ $media->id }}, '{{ $media->getCustomProperty('caption') }}')"
                                        class="btn btn-font-primary">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('admin.albums.media.store', $album) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <h4 class="mt-5">Add new photo</h4>
                    <div class="row align-items-end">
                        <div class="col-3">
                            <div class="mb-0 form-group">
                                <label for="">Photo</label>
                                <input type="file" class="form-control" name="photo">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-0 form-group">
                                <label for="">Caption</label>
                                <input type="text" class="form-control" name="caption">
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
            <h4>Edit Photo</h4>
            <input type="hidden" id="editAlbumId">
            <input type="hidden" id="editMediaId">
            <div class="form-group">
                <label for="name" class="block text-sm font-medium">Photo</label>
                <input type="file" name="photo" id="editPhoto" class="form-control">
            </div>
            <div class="form-group">
                <label for="caption" class="block text-sm font-medium">Caption</label>
                <input type="text" name="caption" id="editCaption" class="form-control" required>
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
            <h4>Delete Photo</h4>
            <p>Are you sure you want to delete <span id="deleteCaption" class="font-weight-bold"></span>?</p>
            <input type="hidden" name="deleteAlbumId" id="deleteAlbumId">
            <input type="hidden" name="deleteMediaId" id="deleteMediaId">
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
            function openEditDialog(albumId, mediaId, caption) {
                document.getElementById('editAlbumId').value = albumId;
                document.getElementById('editMediaId').value = mediaId;
                document.getElementById('editCaption').value = caption;
                document.getElementById('editDialog').showModal();
            }

            function closeEditDialog() {
                document.getElementById('editDialog').close();
            }

            function openDeleteDialog(deleteAlbumId, deleteMediaId, caption) {
                document.getElementById('deleteAlbumId').value = deleteAlbumId;
                document.getElementById('deleteMediaId').value = deleteMediaId;
                document.getElementById('deleteCaption').textContent = caption;
                document.getElementById('deleteDialog').showModal();
            }

            function closeDeleteDialog() {
                document.getElementById('deleteDialog').close();
            }

            document.getElementById('editForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const albumId = document.getElementById('editAlbumId').value;
                const mediaId = document.getElementById('editMediaId').value;
                const formData = new FormData();

                const photoFile = document.getElementById('editPhoto').files[0];
                if (photoFile) {
                    formData.append('photo', photoFile);
                }
                formData.append('caption', document.getElementById('editCaption').value);
                formData.append('_method', 'PUT');

                try {
                    const response = await axios.post(`/admin/albums/${albumId}/media/${mediaId}`, formData);

                    closeEditDialog();
                    window.location.reload();
                } catch (error) {
                    alert('Failed: ' + (error.response?.data?.message || 'Unknown error'));
                }
            });

            document.getElementById('deleteForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const albumId = document.getElementById('deleteAlbumId').value;
                const mediaId = document.getElementById('deleteMediaId').value;

                console.log(`/admin/albums/${albumId}/media/${mediaId}`);

                try {
                    axios.post(`/admin/albums/${albumId}/media/${mediaId}`, {
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
