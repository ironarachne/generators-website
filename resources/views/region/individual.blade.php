<p>{{ $region->name }} is ruled by {{ $region->ruler->primary_title }} {{ $region->ruler->last_name }}. Its capital
    is {{ $region->capital->name }}.</p>
<p>{{ $region->area_description }}</p>
<div class="box">
    <article class="media">
        <div class="media-left">
            <figure class="heraldry">
                <img src="{{ $region->ruler->heraldry->url }}" height="450">
                <p><em>{{ $region->ruler->heraldry->blazon }}</em></p>
            </figure>
        </div>
        <div class="media-content">
            <p class="title">{{ $region->ruler->primary_title }} {{ $region->ruler->first_name }} {{ $region->ruler->last_name }}</p>
            <hr>
            <p>{{ $region->ruler->description }}</p>
        </div>
    </article>
</div>

<h4 class="title is-4">Notable Towns in {{ $region->name }}</h4>

<div class="content">
    <h5 class="title is-5">{{ $region->capital->name }}<span>, the capital and
{{ $region->ruler->primary_title }} {{ $region->ruler->last_name }}'s home</span></h5>
    <p>{{ $region->capital->description }}</p>
</div>

@foreach($region->towns as $town)
    <div class="content">
        <h5 class="title is-5">{{ $town->name }}</h5>
        <p>{{ $town->description }}</p>
    </div>
@endforeach

@if (!empty($region->organizations))
    <h4 class="title is-4">Notable Organizations in {{ $region->name }}</h4>
    @foreach ($region->organizations as $organization)
        <div class="content">
            <h5 class="title is-5">The {{ $organization->name }}</h5>
            <p>{{ $organization->description }}</p>
        </div>
    @endforeach
@endif
