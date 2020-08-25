@extends('layout')

@section('title')
    Generated Heraldry
@endsection

@section('subtitle')
    {{ $heraldry->blazon }}
@endsection

@section('description')
    {{ $heraldry->blazon }}
@endsection

@section('content')
<div class="heraldry-large">
    <p>{{ $heraldry->blazon }}</p>
    <img src="{{ $heraldry->url }}" alt="{{ $heraldry->blazon }} coat of arms">
</div>
@endsection
