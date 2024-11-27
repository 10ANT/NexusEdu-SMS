@extends('layouts.master')
@section('content')
<div>
    <h2>Analysis Results</h2>
    <p>Total Score: {{ $totalScore }}</p>
    <p>Percentage: {{ number_format($percentage, 2) }}%</p>
    
    <h3>Individual Papers:</h3>
    @foreach($results as $result)
        <div>
            <p>{{ $result['filename'] }}: {{ $result['score'] }} points</p>
        </div>
    @endforeach
</div>
@endsection