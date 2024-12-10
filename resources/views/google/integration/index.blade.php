@extends('layouts.master')

@section('content')

<style>
    /* Label Styling */
label {
    display: block;
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

/* Input Field Styling */
input[type="text"],
input[type="email"],
input[type="password"],
textarea,
select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ccc;
    border-radius: 0.375rem;
    font-size: 1rem;
    color: #333;
    background-color: #f9f9f9;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s, box-shadow 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
textarea:focus,
select:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    outline: none;
}

/* Button Styling */
button {
    padding: 0.5rem 1rem;
    font-size: 1rem;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}

button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

/* Form Group */
.form-group {
    margin-bottom: 1.5rem;
}

</style>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Google Integration</h4>
        <div class="btn-group">
                      <div class="dropdown-menu">
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createClassroomModal">
                    <i class="fas fa-graduation-cap me-2"></i>Create Classroom
                </a>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createDriveFolderModal">
                    <i class="fas fa-folder-plus me-2"></i>Create Drive Folder
                </a>
            </div>
        </div>
    </div>

    @php
$isGoogleConnected = Auth::user()->googleCredential()->exists();
@endphp

@if($isGoogleConnected)
    <button type="button" class="btn btn-primary" style="background: rgb(139, 233, 45); width:200px; margin:auto" data-bs-toggle="modal" data-bs-target="#createClassroomModal">
        Your Connected
    </button><br>
    <a href="{{ route('google.auth') }}" class="btn btn-primary" style="width:250px; margin:auto">
        Connect with Google or Re-Authenticate
    </a>
@else
<a href="{{ route('google.auth') }}" class="btn btn-primary" style="width:250px; margin:auto">
    Connect with Google or Re-Authenticate
</a>
@endif
    <div class="card-body">
        <!-- Tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#classrooms">
                    <i class="fas fa-graduation-cap me-2"></i>Classrooms
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#drive-folders">
                    <i class="fas fa-folder me-2"></i>Drive Folders
                </a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3">
            <!-- Classrooms Tab -->
            <div class="tab-pane fade show active" id="classrooms">
                <div class="row">
                    @forelse($classrooms as $classroom)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-graduation-cap fa-2x text-primary me-2"></i>
                                    <h5 class="mb-0">{{ $classroom->course_name }}</h5>
                                </div>
                                <p class="mb-1"><strong>Section:</strong> {{ $classroom->section }}</p>
                                <p class="mb-1"><strong>Room:</strong> {{ $classroom->room }}</p>
                                <div class="mt-3 d-flex justify-content-between">
                                    <div>
                                        <a href="https://classroom.googleapis.com/v1/courses/{{$classroom->id}}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i>Details
                                        </a>
                                        
                                        <a href="{{ $classroom->course_link }}" target="_blank" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-external-link-alt me-1"></i>Open
                                        </a>
                                    </div>
                                    <button class="btn btn-sm btn-danger delete-classroom" data-course-id="{{ $classroom->course_id }}">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- ... existing empty state ... -->
                    @endforelse
                </div>
            </div>

            <!-- Drive Folders Tab -->
            <div class="tab-pane fade" id="drive-folders">
                <div class="row">
                    @forelse($driveFolders as $folder)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-folder fa-2x text-warning me-2"></i>
                                    <h5 class="mb-0">{{ $folder->folder_name }}</h5>
                                </div>
                                <p class="text-muted small">Created: {{ $folder->created_at->format('M d, Y') }}</p>
                                <div class="mt-3">
                                    <a href="{{ route('drive-folders.show', $folder->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    <a href="{{ $folder->folder_link }}" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-external-link-alt me-1"></i>Open
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center text-muted">
                            <i class="fas fa-folder fa-3x mb-3"></i>
                            <p>No folders created yet</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Classroom Modal -->
@include('google.integration.modals.create-classroom')

<!-- Create Drive Folder Modal -->
@include('google.integration.modals.create-drive-folder')
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Add your JavaScript here
    $('#createClassroomForm').on('submit', function(e) {
        e.preventDefault();
        // Add your AJAX submission logic here
    });

    $('#createDriveFolderForm').on('submit', function(e) {
        e.preventDefault();
        // Add your AJAX submission logic here
    });











    
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to get access token
    async function getAccessToken() {
        try {
            const response = await axios.get('/api/get-access-token');
            if (response.data.success) {
                return response.data.access_token;
            } else {
                throw new Error(response.data.message);
            }
        } catch (error) {
            console.error('Error fetching access token:', error);
            return null;
        }
    }

    // Delete Classroom functionality
    document.querySelectorAll('.delete-classroom').forEach(button => {
        button.addEventListener('click', async function() {
            const courseId = this.dataset.courseId;
            const accessToken = await getAccessToken();

            if (!accessToken) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to retrieve access token'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this classroom?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`https://classroom.googleapis.com/v1/courses/${courseId}`, {
                        headers: {
                            'Authorization': `Bearer ${accessToken}`
                        }
                    })
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Classroom has been deleted.'
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.response?.data?.message || 'Something went wrong'
                        });
                        console.error('Error:', error);
                    });
                }
            });
        });
    });
});


    </script>



@endpush