@extends('layout')

@section('title')
    Culture Generator
@endsection

@section('description')
    This tool procedurally generates fantasy cultures
@endsection

@section('content')
    <p>This generator creates a fictional culture from a fantasy world.</p>

    <form method="POST" action="/culture">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="button is-primary is-large" value="Generate New Culture">
    </form>

    <h3>Most Recent Cultures Generated</h3>
    @foreach ($cultures as $culture)
        <div class="content">
            <h4><a href="{{ route('culture.show', ['guid' => $culture->guid]) }}">The {{ $culture->name }} Culture</a>
            </h4>
            <p>{{ $culture->description }}</p>
        </div>
    @endforeach
@endsection
