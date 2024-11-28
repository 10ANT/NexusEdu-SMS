@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Analysis Results</h2>

    <div class="mb-3">
        <p><strong>Total Score:</strong> {{ $totalScore }}</p>
        <p><strong>Percentage:</strong> {{ number_format($percentage, 2) }}%</p>
    </div>
    
    <h3 class="mt-4">Individual Papers:</h3>
    @foreach($results as $result)
        <div class="mb-2">
            <p><strong>{{ $result['filename'] }}:</strong> {{ $result['score'] }} points</p>
        </div>
    @endforeach
</div>
@endsection
