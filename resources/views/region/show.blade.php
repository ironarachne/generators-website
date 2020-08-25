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
    {!! $region->html !!}
@endsection
