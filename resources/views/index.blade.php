@extends('layout')

@section('title')
    Iron Arachne
@endsection

@section('subtitle')
    Procedural Generation Tools for Tabletop Role-playing Games
@endsection

@section('description')
    Procedural Generation Tools for Tabletop Role-playing Games
@endsection

@section('content')
    <p>This website hosts tools intended to make life easier for players of tabletop RPGs. It's a living website,
        and will continue to receive new tools on a semiregular basis.</p>
    <p>My name is <a href="https://benovermyer.com">Ben Overmyer</a>. I'm the developer behind this site and the
        tools it presents. I'm happy to take suggestions - either for my existing generators, or for new tools you wish
        existed. Email me at <a href="mailto:ben@ironarachne.com">ben@ironarachne.com</a>!</p>

    @foreach($posts as $post)
        <article class="post">
            <h2><img class="art-icon" src="{{ asset('img/art-icons/blog_post.png') }}"> {{ $post['title'] }}</h2>
            <p class="date">Published {{ date('l F jS, Y', strtotime($post['created'])) }}</p>
            <div>{!! $post['body'] !!}</div>
        </article>
    @endforeach
@endsection
