<p>This culture is called the <em>{{ $culture->name }}</em>. Its people are the {{ $culture->adjective }}.</p>
<p>They speak {{ $culture->language->name }}. {{ $culture->language->description }}</p>

<p>They originally came from a {{ $culture->geography->biome->name }} region.</p>

<h2><img class="art-icon" src="{{ asset('img/art-icons/names.png') }}"> Common Names</h2>

<div class="columns">
    <div class="column">
        <h4>Male Names</h4>
        <ul>
            @foreach ($culture->language->male_first_names as $name)
                @if ($loop->iteration < 11)
                    <li>{{ $name }}</li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="column">
        <h4>Female Names</h4>
        <ul>
            @foreach ($culture->language->female_first_names as $name)
                @if ($loop->iteration < 11)
                    <li>{{ $name }}</li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="column">
        <h4>Family Names</h4>
        <ul>
            @foreach ($culture->language->male_last_names as $name)
                @if ($loop->iteration < 11)
                    <li>{{ $name }}</li>
                @endif
            @endforeach
        </ul>
    </div>
</div>

<h2><img class="art-icon" src="{{ asset('img/art-icons/music.png') }}"> Music</h2>

<p>{{ $culture->music->description }}</p>

<h2><img class="art-icon" src="{{ asset('img/art-icons/clothing.png') }}"> Clothing</h2>

<p>As the {{ $culture->adjective }} hail originally from a {{ $culture->geography->biome->name }} region, their clothing
    style is appropriate for that kind of place. They often wear the following:
</p>

<h3>Male Clothing</h3>

<p>Men usually wear {{ $culture->clothing->male_outfit }}.</p>

<h3>Female Clothing</h3>

<p>Women usually wear {{ $culture->clothing->female_outfit }}.</p>

<h2><img class="art-icon" src="{{ asset('img/art-icons/food.png') }}"> Food and Drink</h2>

<p>{{ $culture->cuisine->description }}</p>

<p>They have {{ $culture->drink->description }}.</p>

<h2><img class="art-icon" src="{{ asset('img/art-icons/religion.png') }}"> Religion</h2>
<p>The {{ $culture->adjective }} have a {{ $culture->religion->category->name }} outlook. They gather in
    {{ $culture->religion->gathering_place }}s.</p>
@if ($culture->religion->category->has_pantheon)
    <h3>Deities</h3>
    <p>The deities of the {{ $culture->adjective }} are as follows:</p>
    @foreach ($culture->religion->pantheon->deities as $deity)
        <h4>{{ $deity->name }}</h4>
        <p>{{ $deity->description }}</p>
    @endforeach
@endif
