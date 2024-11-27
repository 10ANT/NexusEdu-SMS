
@extends('layouts.master')
@section('content')
<form action="{{ route('analyze.papers') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Upload Test Papers (max 8):</label>
        <input type="file" name="papers[]" multiple accept="image/*" required>
    </div>
    <div>
        <label>Total Questions:</label>
        <input type="number" name="total_questions" required>
    </div>
    <button type="submit">Analyze Papers</button>
</form>
@endsection