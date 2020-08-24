@extends('layout')

@section('title')
    Region Generator
@endsection

@section('content')
    <p>This generator creates a region from a fantasy world.</p>

    <form method="POST" action="/region">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="input-group">
            <p>What language should we use?</p>
            <label class="radio">
                <input type="radio" name="language-choice" checked value="Common">
                Common
            </label>
            <label class="radio">
                <input type="radio" name="language-choice" value="Conlang">
                Constructed Language
            </label>
        </div>
        <input type="submit" value="Generate New Region">
    </form>

    <h2>Most Recent Regions Generated</h2>

    @foreach ($regions as $region)
            <h3><a href="{{ route('region.show', ['guid' => $region->guid]) }}">{{ $region->name }}</a></h3>
            <p>{{ $region->description }}</p>
    @endforeach
@endsection
