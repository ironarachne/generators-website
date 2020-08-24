@extends('layout')

@section('title')
    Region: {{ $region->name }}
@endsection

@section('subtitle')
    {{ $region->description }}
@endsection

@section('description')
    {{ $region->description }}
@endsection

@section('content')
    <h1 class="is-title is-1">{{ $region->name }}</h1>

    {!! $region->html !!}
@endsection
