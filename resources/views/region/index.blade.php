@extends('layout')

@section('title')
    Region Generator
@endsection

@section('content')
    <p>This generator creates a region from a fantasy world.</p>

    <div class="box">

        <form method="POST" action="/region">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="field">
                <p>What language should we use?</p>
                <div class="control">
                    <label class="radio">
                        <input type="radio" name="language-choice" checked value="Common">
                        Common
                    </label>
                    <label class="radio">
                        <input type="radio" name="language-choice" value="Conlang">
                        Constructed Language
                    </label>
                </div>
            </div>
            <input type="submit" class="button is-primary is-large" value="Generate New Region">
        </form>

    </div>

    <h3>Most Recent Regions Generated</h3>
    @foreach ($regions as $region)
        <div class="content">
            <h4><a href="{{ route('region.show', ['guid' => $region->guid]) }}">{{ $region->name }}</a></h4>
            <p>{{ $region->description }}</p>
        </div>
    @endforeach
@endsection
