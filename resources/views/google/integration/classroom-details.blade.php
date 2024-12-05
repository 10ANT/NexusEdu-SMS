@extends('layouts.master')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{ $classroom->course_name }} Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Course Name:</strong> {{ $classroom->course_name }}</p>
                    <p><strong>Section:</strong> {{ $classroom->section }}</p>
                    <p><strong>Room:</strong> {{ $classroom->room }}</p>
                    <p><strong>Created At:</strong> {{ $classroom->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection