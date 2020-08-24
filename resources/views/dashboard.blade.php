@extends('layout')

@section('title')
    My Dashboard
@endsection

@section('subtitle')
    Your personal dashboard
@endsection

@section('content')
    <p>This is your dashboard. Your creations appear here.</p>

    <div class="columns">
        <div class="column">
            <h2>Cultures</h2>

            <ul>
                @foreach ($cultures as $culture)
                    <li><a href="{{ route('culture.show', ['guid' => $culture['guid']]) }}">{{ $culture['name'] }}</li>
                @endforeach
            </ul>
        </div>
        <div class="column">
            <h2>Regions</h2>

            <ul>
                @foreach ($regions as $region)
                    <li><a href="{{ route('region.show', ['guid' => $region['guid']]) }}">{{ $region['name'] }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="column">
            <h2>Heraldry</h2>

            @foreach ($devices as $device)
                <article class="media">
                    <figure class="media-left">
                        <p class="image is-64x64"><img src="{{ $device->url }}" class="heraldry-small"></p>
                    </figure>
                    <div class="media-content">
                        <p><a href="{{ route('heraldry.show', ['guid' => $device->guid]) }}">{{ $device->blazon }}</a>
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
@endsection
