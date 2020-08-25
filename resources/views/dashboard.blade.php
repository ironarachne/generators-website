@extends('layout')

@section('title')
    {{ Auth::user()->name }}'s Dashboard
@endsection

@section('subtitle')
    Your personal dashboard
@endsection

@section('content')
    <p>This is your dashboard. Your creations appear here.</p>

    <h2>Your Creations</h2>

    <div class="columns">
        <div class="column">
            <h3>Cultures</h3>

            <ul>
                @foreach ($cultures as $culture)
                    <li><a href="{{ route('culture.show', ['guid' => $culture['guid']]) }}">{{ $culture['name'] }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="column">
            <h3>Regions</h3>

            <ul>
                @foreach ($regions as $region)
                    <li><a href="{{ route('region.show', ['guid' => $region['guid']]) }}">{{ $region['name'] }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="column">
            <h3>Heraldry</h3>

            @foreach ($devices as $device)
                <article class="heraldry-list">
                    <img src="{{ $device->url }}">
                    <p><a href="{{ route('heraldry.show', ['guid' => $device->guid ]) }}">{{ $device->blazon }}</a></p>
                </article>
            @endforeach
        </div>
    </div>
@endsection
