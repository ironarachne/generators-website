@extends('layout')

@section('title')
    Heraldry Generator
@endsection

@section('content')
    <p>This generator creates a fictional coat-of-arms and accompanying blazon.<p>

    {{ Form::open() }}

    @if ($errors->any())
        @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    @endif

    <div class="input-group">
        {{ Form::label('field_shape', 'Field Shape', ['class' => 'label']) }}

        {{ Form::select('field_shape', ['any' => 'Any', 'banner' => 'Banner', 'engrailed' => 'Engrailed', 'wedge' => 'Wedge'], 'any') }}
    </div>

    {{ Form::submit('Generate') }}

    {{ Form::close() }}

    <h2>Most Recent Heraldry Generated</h2>
    @foreach ($devices as $device)
        <article class="heraldry-list">
            <img src="{{ $device->url }}">
            <p><a href="{{ route('heraldry.show', ['guid' => $device->guid ]) }}">{{ $device->blazon }}</a></p>
        </article>
    @endforeach
@endsection
