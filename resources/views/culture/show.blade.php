@extends('layout')

@section('title')
    The {{ $culture->name }} Culture
@endsection

@section('subtitle')
    {{ $culture->description }}
@endsection

@section('description')
    {{ $culture->description }}
@endsection

@section('content')
    <h2 class="title is-2">The {{ $culture->name }} Culture</h2>

    {!! $culture->html !!}
@endsection
