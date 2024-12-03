@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Google Integration</h4>
        <div class="btn-group">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Create New
            </button>
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
                                <div class="mt-3">
                                    <a href="{{ route('classroom.show', $classroom->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>Details
                                    </a>
                                    <a href="{{ $classroom->course_link }}" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-external-link-alt me-1"></i>Open
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center text-muted">
                            <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                            <p>No classrooms created yet</p>
                        </div>
                    </div>
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
@endpush