<p>{{ $region->name }} is ruled by {{ $region->ruler->primary_title }} {{ $region->ruler->last_name }}. Its capital
    is {{ $region->capital->name }}.</p>
<p>{{ $region->area_description }}</p>

<div class="columns">
    <div class="column">
        <figure class="heraldry">
            <img src="{{ $region->ruler->heraldry->url }}" height="450">
            <p><em>{{ $region->ruler->heraldry->blazon }}</em></p>
        </figure>
    </div>
    <div class="column">
        <h2>{{ $region->ruler->primary_title }} {{ $region->ruler->first_name }} {{ $region->ruler->last_name }}</h2>
        <p>{{ $region->ruler->description }}</p>
    </div>
</div>

<h2>Notable Towns in {{ $region->name }}</h2>

<h3>{{ $region->capital->name }}<span>, the capital and
{{ $region->ruler->primary_title }} {{ $region->ruler->last_name }}'s home</span></h3>
<p>{{ $region->capital->description }}</p>

@foreach($region->towns as $town)
        <h3>{{ $town->name }}</h3>
        <p>{{ $town->description }}</p>
@endforeach

@if (!empty($region->organizations))
    <h2>Notable Organizations in {{ $region->name }}</h2>
    @foreach ($region->organizations as $organization)
        <h3>The {{ $organization->name }}</h3>
        <p>{{ $organization->description }}</p>
    @endforeach
@endif
