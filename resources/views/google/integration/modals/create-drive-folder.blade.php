<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createDriveFolderModal">
    Create Drive Folder
</button>


<div class="modal fade" id="createDriveFolderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Drive Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createDriveFolderForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Folder Name</label>
                        <input type="text" name="folder_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#createDriveFolderForm').on('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Creating folder...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    var formData = new FormData(this);

    $.ajax({
        url: '/drive-folder/create',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message
                }).then(() => {
                    $('#createDriveFolderForm')[0].reset();
                    $('#createDriveFolderModal').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong'
            });
        }
    });
});
</script>