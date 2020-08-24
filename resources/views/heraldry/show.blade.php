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
<div class="has-text-centered">
    <p class="blazon is-italic is-size-3">{{ $heraldry->blazon }}</p>
    <img src="{{ $heraldry->url }}">
</div>
@endsection
