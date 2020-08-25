@extends('layout')

@section('title')
    Culture Generator
@endsection

@section('subtitle')
    A generator of fantasy cultures
@endsection

@section('description')
    This tool procedurally generates fantasy cultures
@endsection

@section('content')
    <p>This generator creates a fictional culture from a fantasy world.</p>

    <form method="POST" action="/culture">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="button" value="Generate New Culture">
    </form>

    <h2>Most Recent Cultures Generated</h2>
    @foreach ($cultures as $culture)
        <h3><a href="{{ route('culture.show', ['guid' => $culture->guid]) }}">The {{ $culture->name }} Culture</a>
        </h3>
        <p>{{ $culture->description }}</p>
    @endforeach
@endsection
