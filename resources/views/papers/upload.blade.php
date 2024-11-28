@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Analyze Test Papers</h2>
    <form action="{{ route('analyze.papers') }}" method="POST" enctype="multipart/form-data">
        @csrf


        <div class="mb-3">
            <label for="papers" class="form-label">Upload Test Papers (max 8):</label>
            <input type="file" name="papers[]" id="papers" class="form-control" multiple accept="image/*" required>
        </div>

 
        <div class="mb-3">
            <label for="total_marks" class="form-label">Total Marks:</label>
            <input type="number" name="total_marks" id="total_marks" class="form-control" required>
        </div>

  
        <button class="btn btn-primary" type="submit">Analyze Papers</button>
    </form>
</div>
@endsection
