<p>This culture is called the <em>{{ $culture->name }}</em>. Its people are the {{ $culture->adjective }}.</p>
<p>They speak {{ $culture->language->name }}. {{ $culture->language->description }}</p>

<p>They originally came from a {{ $culture->geography->biome->name }} region.</p>

<h3 class="title is-3">Common Names</h3>
<div class="columns">
    <div class="column">
        <h4 class="title is-4">Male Names</h4>
        <ul>
            @foreach ($culture->language->male_first_names as $name)
                @if ($loop->iteration < 11)
                    <li>{{ $name }}</li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="column">
        <h4 class="title is-4">Female Names</h4>
        <ul>
            @foreach ($culture->language->female_first_names as $name)
                @if ($loop->iteration < 11)
                    <li>{{ $name }}</li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="column">
        <h4 class="title is-4">Family Names</h4>
        <ul>
            @foreach ($culture->language->male_last_names as $name)
                @if ($loop->iteration < 11)
                    <li>{{ $name }}</li>
                @endif
            @endforeach
        </ul>
    </div>
</div>

<h3 class="title is-3">Music</h3>
<p>{{ $culture->music->description }}</p>

<h3 class="title is-3">Clothing</h3>
<p>As the {{ $culture->adjective }} hail originally from a {{ $culture->geography->biome->name }} region, their clothing
    style is appropriate for that kind of place. They often wear the following:
</p>
<h4 class="title is-4">Male Clothing</h4>
<p>Men usually wear {{ $culture->clothing->male_outfit }}.</p>
<h4 class="title is-4">Female Clothing</h4>
<p>Women usually wear {{ $culture->clothing->female_outfit }}.</p>

<h3 class="title is-3">Food and Drink</h3>

<p>{{ $culture->cuisine->description }}</p>

<p>They have {{ $culture->drink->description }}.</p>

<h3 class="title is-3">Religion</h3>
<p>The {{ $culture->adjective }} have a {{ $culture->religion->category->name }} outlook. They gather in
    {{ $culture->religion->gathering_place }}s.</p>
@if ($culture->religion->category->has_pantheon)
    <div class="content">
        <h4 class="title is-4">Deities</h4>
        <p>The deities of the {{ $culture->adjective }} are as follows:</p>
        @foreach ($culture->religion->pantheon->deities as $deity)
            <div class="content">
                <h5 class="title is-5">{{ $deity->name }}</h5>
                <p>{{ $deity->description }}</p>
            </div>
        @endforeach
    </div>
@endif
