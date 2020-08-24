@extends('layout')

@section('title')
    Heraldry Generator
@endsection

@section('content')
    <p>This generator creates a fictional coat-of-arms and accompanying blazon.<p>

    {{ Form::open() }}

    @if ($errors->any())
        @foreach($errors->all() as $error)
        <h4 class="has-text-danger">{{ $error }}</h4>
        @endforeach
    @endif

    <div class="field">
        {{ Form::label('field_shape', 'Field Shape', ['class' => 'label']) }}

        <div class="select">
            {{ Form::select('field_shape', ['any' => 'Any', 'banner' => 'Banner', 'engrailed' => 'Engrailed', 'wedge' => 'Wedge'], 'any') }}
        </div>
    </div>

    {{ Form::submit('Generate', ['class' => 'button is-primary is-large']) }}

    {{ Form::close() }}

    <h3>Most Recent Heraldry Generated</h3>
    @foreach ($devices as $device)
        <article class="media">
            <figure class="media-left">
                <p class="image is-64x64"><img src="{{ $device->url }}" class="heraldry-small"></p>
            </figure>
            <div class="media-content">
                <p><a href="{{ route('heraldry.show', ['guid' => $device->guid ]) }}">{{ $device->blazon }}</a></p>
            </div>
        </article>
    @endforeach
@endsection
