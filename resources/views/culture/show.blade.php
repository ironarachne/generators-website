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
    {!! $culture->html !!}
@endsection
